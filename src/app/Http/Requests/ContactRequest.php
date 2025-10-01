<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'last_name'     =>['required','string', 'max:255'],
            'first_name'    =>['required', 'string','max:255'],
            'gender'        =>['required','in:1,2,3'],
            'email'         =>['required','string','email','max:255'],
            'tel1'          => ['required','digits_between:2,4'],
            'tel2'          => ['required','digits_between:3,4'],
            'tel3'          => ['required','digits_between:3,4'],
            'address'       =>['required','string','max:255'],
            'building'      =>['nullable','string','max:255'],
            'category_id'   =>['required','exists:categories,id'],
            'detail'        =>['required','string','max:120'],
        ];
    }
    public function messages(){
        return[
            'last_name.required'   => '性を入力してください',
            'first_name.required'  => '名を入力してください',
            'gender.required'      => '性別を選択してください',
            'email.required'       => 'メールアドレスを入力してください',
            'email.email'          => 'メールアドレスをメール形式で入力してください',
            'address.required'     => '住所を入力してください',
            'category_id.required' => 'お問合せの種類を選択してください',
            'detail.required'      => 'お問合せ内容を入力してください',
            'detail.max'           =>'お問合せ内容は120文字以内で入力してください',
        ];
    }
    public function withValidator($validator){
        $validator->after(function ($validator) {
            $tel1 = $this->input('tel1');
            $tel2 = $this->input('tel2');
            $tel3 = $this->input('tel3');
            if (!$tel1 || !$tel2 || !$tel3 || !preg_match('/^\d{10,11}$/', $tel1.$tel2.$tel3)) {
                $validator->errors()->add('tel', '電話番号を入力してください');
            }
        });
    }
}