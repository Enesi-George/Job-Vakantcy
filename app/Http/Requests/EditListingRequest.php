<?php

namespace App\Http\Requests;

use App\Data\ListingDTOData;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redirect;

class EditListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Redirect back with errors
        throw new HttpResponseException(Redirect::back()->withErrors($errors)->withInput());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'company' => 'required',
            'location' => 'required|string|max:255',
            'website' => 'required|url',
            'email' => ['required', 'email'],
            'tags' => 'required|string',
            'logo' => ['nullable', 'file', 'mimes:png,jpeg,jpg', 'max:5120'], //file size is 5mb
            'salary' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today', // Ensuring the date is today or in the future
            'description' => 'required|string',
            'requirements' => 'required|string',
        ];
    }

    public function ListingDTO(): ListingDTOData
    {
        return new ListingDTOData(
            title: $this->title,
            company: $this->company,
            location: $this->location,
            website: $this->website,
            email: $this->email,
            tags: $this->tags,
            logo: $this->logo,
            salary: $this->salary,
            deadline: $this->deadline,
            description: $this->description,
            requirements: $this->requirements,
        );
    }
}
