<?php

namespace App\Http\Requests;

use App\Services\Validation\FormRequestPerpareForValidationServices;
use Illuminate\Foundation\Http\FormRequest;

class PackageUpdateRequest extends FormRequest
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
            'name'=>['nullable','string'],
            'amount'=>['nullable','numeric'],
            'price'=>['nullable','numeric'],
            'is_popular'=>['nullable','boolean'],
            'status'=>['nullable','numeric']
        ];
    }

    protected function prepareForValidation()
    {
        $inputs=FormRequestPerpareForValidationServices::filterNullAndEmptyFields($this->all());
        $this->replace($inputs);
    }
}
