<?php

namespace App\Http\Requests;

use \Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScoreFormRequest extends FormRequest
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
            'scores.*.score' => 'required|numeric|between:0,10',
            'subject.*' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'scores.*.score.required' => 'The score field is required.',
            'scores.*.score.numeric' => 'The score must be a number.',
            'scores.*.score.min' => 'The score must be at least :min.',
            'scores.*.score.between' => 'The score must be from 0 to 10.',
            'subject.*.required' => "The subject field is required.",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        session()->flash('old_html', request()->scores);
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator->errors())->withInput()
        );
    }
}
