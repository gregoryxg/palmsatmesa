<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicket extends FormRequest
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
            'ticket_type_id'=>['required', 'integer', 'exists:ticket_types,id'],
            'subject'=>['required', 'string', 'profanity', 'min:1', 'max:50'],
            'body'=>['required', 'string', 'profanity', 'min:1', 'max:2000']
        ];
    }

    public function messages()
    {
        return [
            'ticket_type_id.exists'=>'Ticket type does not exist',
            
            'subject.profanity'=>'No profanity is allowed',

            'body.profanity'=>'No profanity is allowed'
        ];
    }
}
