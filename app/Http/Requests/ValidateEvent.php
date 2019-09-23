<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Reservable;

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
            'date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:'.date('Y-m-d', strtotime("+7 days")),
                'before_or_equal:'.date('Y-m-d', strtotime("+".config('event.maxRange') . " days")),
                'event_buffer:true'
            ],
            'start_time' => ['required', 'date_format:g:i A', 'after_or_equal:9:00 AM', 'before_or_equal:8:00 PM'],
            'end_time' => ['required', 'date_format:g:i A', 'after_or_equal:10:00 AM', 'before_or_equal:9:00 PM', 'event_duration:true'],
            'reservable_id' => ['required', 'integer', 'exists:reservables,id'],
            'size' => ['required', 'integer', 'min:1', 'max:'.Reservable::find($this->reservable_id)->guest_limit],
            'agree_to_terms' => ['accepted'],
            'esign_consent' => ['accepted']
        ];
    }

    public function messages()
    {
        return [

            'date.event_buffer'=>'Reservation date must not be within ' . config('event.daysPerEvent') . ' days of another event for your unit.',

            'end_time.event_duration'=>'Reservations must not exceed 4 hours.',

            'size.max'=>'The maximum guests for the ' . Reservable::find($this->reservable_id)->description . ' is ' . Reservable::find($this->reservable_id)->guest_limit . '.'
        ];
    }
}
