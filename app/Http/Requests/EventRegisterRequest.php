<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRegisterRequest extends FormRequest
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
            'user_name'       => 'required|string',
            'user_email'      => [
                'required',
                'email',
                Rule::unique('event_registrations', 'user_email')->where(function ($query) {
                    $query->where('event_id', $this->input('event_id'));
                }),
            ]
        ];
    }
}
