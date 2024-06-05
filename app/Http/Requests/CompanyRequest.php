<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'company_name'         => ['required', 'string', 'max:190'],
            'company_email'        => ['required', 'email', 'max:190'],
            'company_phone'        => ['required', 'string', 'max:20'],
            'company_website'      => ['nullable', 'url', 'max:500'],
            'company_city'         => ['required', 'string', 'max:190'],
            'company_state'        => ['required', 'string', 'max:190'],
            'company_country_code' => ['required', 'string', 'max:190'],
            'company_zip_code'     => ['required', 'string', 'max:190'],
            'company_address'      => ['required', 'string', 'max:500'],
        ];
    }
}
