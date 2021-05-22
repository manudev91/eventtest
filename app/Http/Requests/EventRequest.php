<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            //
            'event_name' => 'required',
            'event_description' => 'required',
            'event_venue' => 'required',
            'event_location' => 'required',
            'event_start_date'=> 'required|date',
            'event_start_time' => 'date_format:H:i',
            'event_end_date' => 'required|date|after_or_equal:event_start_date',
            'event_end_time' => 'date_format:H:i|after:event_start_time',
            'status' => 'required',
        ];
    }
   

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
      return [];
    }
}
