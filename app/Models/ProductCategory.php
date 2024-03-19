<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    public function getProducts(){
        return $this->hasMany(Product::class, "category_id");
    }

    public function addProductCategory(Request $request){
        $cat = new ProductCategory();
        $cat->org_id = Auth::user()->org_id;
        $cat->name = $request->name;
        $cat->slug = Str::slug($request->name).'-'.Str::random(8);
        $cat->save();
    }
    public function editProductCategory(Request $request){
        $cat =  ProductCategory::find($request->categoryId);
        $cat->org_id = Auth::user()->org_id;
        $cat->name = $request->name;
        //$cat->slug = Str::slug($request->name).'-'.Str::random(8);
        $cat->save();
    }

    public function getAllOrgProductCategories(){
        return ProductCategory::where('org_id', Auth::user()->org_id)->orderBy('name', 'ASC')->get();
    }
}
