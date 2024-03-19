<?php
namespace App\Http\Traits;

trait UtilityTrait{

    public function getIntegerArray($arr){
        $values = [];
        for($i = 0; $i<count($arr); $i++){
            array_push($values, (int) $arr[$i]);
        }
        return $values;
    }

    public function getPostType($typeId){
        $type = '';
        switch ($typeId){
            case 1:
                $type = 'Message';
                break;
            case 2:
                $type = 'Memo';
                break;
            case 3:
                $type = 'Announcement';
                break;
            case 4:
                $type = 'Directive';
                break;
            case 5:
                $type = 'Project';
                break;
            case 6:
                $type = 'Expense request';
                break;
            case 7:
                $type = 'Expense report';
                break;
            case 8:
                $type = 'Attendance';
                break;
            case 9:
                $type = 'Event';
                break;
        }
        return $type;
    }
}
?>
