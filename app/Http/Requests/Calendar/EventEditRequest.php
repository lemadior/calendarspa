<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class EventEditRequest extends FormRequest
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
            'id' => 'required|integer|min:1',
            'event' => 'integer|exists:events,id',
            'dayDate' => 'required|string|date_format:Y.m.d',
            'date' => 'nullable|string|date_format:Y-m-d',
            'isExpired' => 'required|boolean'
        ];
    }
}
