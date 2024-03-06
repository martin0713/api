<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' =>'required|string',
            'body' =>'required|string',
            'image' =>'required|string',
            'user_id' =>'required|integer',
            'records.time' =>'required|integer'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'body.required' => 'The body field is required.',
            'body.string' => 'The body must be a string.',
            'image.required' => 'The image field is required.',
            'image.string' => 'The image must be a string.',
            'user_id.required' => 'The user_id field is required.',
            'user_id.integer' => 'The user_id must be an integer.',
            'records.time.required' => 'The time field is required.',
        ];
    }

    protected $redirect = '/failure';
}
