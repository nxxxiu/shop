<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class StoreUserPost extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'user_email'=> 'required|unique:user|email',
            'user_pwd'=>'sometimes|required|max:16|min:2',
            'repwd'=>'sometimes|required|same:user_pwd',
        ];
    }

    //错误信息
    public function messages()
    {
        return [
            'user_email.required'=>'邮箱不能为空',
            'user_email.unique'=>'邮箱已存在',
            'user_email.email'=>'邮箱格式不对',
            'user_pwd.required'=>'密码不能为空',
            'user_pwd.max'=>'密码最大16位',
            'user_pwd.min'=>'密码最少两位',
            'repwd.required'=>'确认密码不能为空',
            'repwd.same'=>'确认密码要和密码一致'
        ];
    }
}
