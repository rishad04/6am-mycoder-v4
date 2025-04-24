<?php

namespace App\Http\Requests\SubscriptionPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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

            'banner'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'title'         => 'required|string',
            'price'         => 'required|integer',
            'is_popular'    => 'nullable',
            'billing_cycle' => 'required|string',
            'description'   => 'nullable|string'
        ];
    }
}
