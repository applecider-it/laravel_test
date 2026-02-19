<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();

        return [
            'name' => $user->validationName(),
            'email' => $user->validationEmail(),
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('myapp.models.user.columns.name'),
            'email' => __('myapp.models.user.columns.email'),
        ];
    }
}
