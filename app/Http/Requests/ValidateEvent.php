<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEvent extends FormRequest
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
            'title' => ['required', 'string', 'max:50'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:'.date('Y-m-d', strtotime("+7 days")), 'before_or_equal:'.date('Y-m-d', strtotime("+90 days"))],
            'start_time' => ['required', 'date_format:H:i:s', 'after_or_equal:09:00:00'],
            'end_time' => ['required', 'date_format:H:i:s', 'before_or_equal:21:00:00'],
            'reservable_id' => ['required', 'integer', 'exists:reservables,id'],
            'size' => ['required', 'integer', 'min:1', 'max:'.Reservable::find($this->reservable_id)->guest_limit],
            'agree_to_terms' => ['accepted'],
            'esign_consent' => ['accepted']
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
