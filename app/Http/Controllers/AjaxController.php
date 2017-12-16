<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Session;

class AjaxController extends Controller
{
    public function getListGroup($id_category)
    {
        $groups = Group::where('id_category', $id_category)->get();
        $checked = "";
        echo "<div class='checkbox'>
                   <label><input type='checkbox' name='checkbox-group-all' id='checkbox-group-all' value=''>Chọn tất cả</label>
              </div>";
        foreach ($groups as $group) {
            if (isset($_POST['checkbox-page'])) {
                foreach ($_POST['checkbox-page'] as $value) {
                    if ($value == $group['id']) {
                        $checked = "checked";
                        break;
                    } else {
                        $checked = "";
                    }
                }
            }
            $id_user = Session::get('id_user');
            if($id_user === $group->user_id){

            echo " <div class='checkbox'>
                        <label><input type='checkbox' name='checkbox-group[]' class='checkbox-group' value='" . $group->group_id . "' " . $checked . ">" . $group->group_name . " - " . $group->group_id . "</label>
                   </div>";
            }
        }
        echo "<script>
                    $('#checkbox-group-all').change(function () {                                   
                        if(this.checked ){
                            $('.checkbox-group').attr('checked','checked');
                        }else{
                             $('.checkbox-group').removeAttr('checked');
                        }
                    });
               </script>";
    }
}

