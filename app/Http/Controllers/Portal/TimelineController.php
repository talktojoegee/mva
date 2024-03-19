<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Traits\UtilityTrait;
use App\Models\AuthorizingPerson;
use App\Models\ChurchBranch;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\PostCorrespondingPerson;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    use UtilityTrait;

    public function __construct()
    {
        $this->user = new User();
        $this->churchbranch = new ChurchBranch();
        $this->region = new Region();
        $this->post = new Post();
        $this->postcorrespondingpersons = new PostCorrespondingPerson();
    }

    public function showTimeline(){
        $branchId = Auth::user()->branch ?? 1;
        $branchPostIds = $this->postcorrespondingpersons->getCorrespondingPostsByBranch(2,$branchId)
            ->pluck('pcp_post_id')->toArray(); //branch related
        $individualPosts = $this->postcorrespondingpersons->getCorrespondingPostsByBranch(4,Auth::user()->id)
            ->pluck('pcp_post_id')->toArray(); //user related
        $regionalPosts = $this->postcorrespondingpersons->getCorrespondingPostsByBranch(3,Auth::user()->id)
            ->pluck('pcp_post_id')->toArray(); //regional
        $postIds = array_merge($branchPostIds, $individualPosts, $regionalPosts);

        return view('timeline.index',[
            'branches'=>$this->churchbranch->getAllChurchBranches(),
            'regions'=>$this->region->getRegions(),
            'users'=>$this->user->getAllBranchUsers($branchId),
            'posts'=>$this->post->getPostsByIds($postIds),
        ]);
    }

    public function storeTimelinePost(Request $request){
        $this->validate($request,[
            'subject'=>'required',
            'postContent'=>'required',
            'type'=>'required',
            'to'=>'required',
        ],[
            "subject.required"=>"What's the subject?",
            "postContent.required"=>"Type the content in the field provided above.",
            "type.required"=>"What for of request is this?",
            "to.required"=>"Kindly indicate target",
        ]);
        $branch = Auth::user()->branch;
        $userId = Auth::user()->id;

        $post = Post::publishPost($userId, $branch, $request->subject, $request->postContent, $request->type,
            0, 76, null, null, 0, $request->to, null);
        $recipient = $request->to;
        switch ($recipient){
            case 2: //For branch
                $this->validate($request,[
                   'branches'=>'required',
                ],['branches.required'=>"Select the church branch(es) concerned"]);

                $values = json_encode($this->getIntegerArray($request->branches));
                PostCorrespondingPerson::storeDetails($post->p_id, 2, $values);
                break;
            case 3: //For region
                $this->validate($request,[
                    'regions'=>'required',
                ],['regions.required'=>"Select the church regions concerned"]);

                $values = json_encode($this->getIntegerArray($request->regions));
                PostCorrespondingPerson::storeDetails($post->p_id, 3, $values);
                break;
            case 4: //For individuals
                $this->validate($request,[
                    'persons'=>'required',
                ],['persons.required'=>"Select the person(s) concerned"]);
                $values = json_encode($this->getIntegerArray($request->persons));
                PostCorrespondingPerson::storeDetails($post->p_id, 4, $values);
                break;

        }
        if ($request->hasFile('attachments')) {
            foreach($request->attachments as $attachment){
                $extension = $attachment->getClientOriginalExtension();
                $size = $attachment->getSize();
                $name = $attachment->getClientOriginalName();
                $filename = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
                $dir = 'assets/drive/cloud/';
                $attachment->move(public_path($dir), $filename);
                $file = new PostAttachment();
                $file->pa_post_id = $post->p_id;
                $file->pa_attachments = $filename;
                $file->pa_size = $size ?? 'N/A';
                $file->pa_name = $name ?? 'N/A';
                $file->save();
            }
        }
        session()->flash("success", "Action successful!");
        return back();
    }

    public function readTimelinePost($slug){
        $post = $this->post->getPostBySlug($slug);
        if(empty($post)){
            abort(404);
        }
        $postType = $this->getPostType($post->p_type);
        $branches = null;
        $regions = null;
        $users = null;
        switch($post->p_scope){
            case 2:
                $ids = $this->post->getCorrespondenceByPostId($post->p_id);
                $branches = $this->churchbranch->getChurchBranchByBranchIds($ids->pcp_target);
                break;
            case 4:
                $ids = $this->post->getCorrespondenceByPostId($post->p_id);
                $users = $this->user->getUserByIds(json_decode($ids->pcp_target));

        }

        return view('timeline.view',[
            'post'=>$post,
            'type'=>$postType,
            'scope'=>$post->p_scope,
            'branches'=>$branches,
            'users'=>$users,
            'regions'=>$regions
        ]);
    }
}
