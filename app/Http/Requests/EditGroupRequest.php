<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'group_id'=>'required',
            'group_name'=>'required',
            'id_category'=>'required'
        ];
    }

    public function messages() {
        return [
            'group_id.required'=>'Id group không dược để trống.',
            'group_name.required'=>'Tên group không được để trống',
            'id_category.required'=>'Thể loại group không được để trống'
        ];
    }
}
