<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class EventsNewOrChangeRequest extends FormRequest
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
            'title' => 'required|string|min:1',
            'start' => 'required|string|date_format:H:i',
            'duration' => 'required',
            'type_id' => 'required',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'date' => 'nullable|string|date_format:Y-m-d'
        ];
    }
}
