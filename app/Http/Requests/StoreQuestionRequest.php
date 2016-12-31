<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //每个人都可以发起请求,因此改为true
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $messages = [
            'title.min' => '标题不能小于 :min 个字符。',
            'title.required' => '标题不能为空',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能小于 :min 个字符。',
        ];
        return $messages;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //there are some validate rules
        $rules = [
            'title' => 'required|min:6|max:255',
            'body' => 'required|min:26',
        ];
        return $rules;
    }
}
