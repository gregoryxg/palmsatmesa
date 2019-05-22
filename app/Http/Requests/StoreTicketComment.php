<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketComment extends FormRequest
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
            'comment'=>['required', 'profanity'],
            'ticket_id'=>['required', 'integer']
        ];
    }

    public function messages()
    {
        return [

            'comment.required' => 'A comment is required',

            'comment.profanity' => 'No profanity is allowed',

            'ticket_id.required' => 'The ticket id # is required'
        ];
    }
}
