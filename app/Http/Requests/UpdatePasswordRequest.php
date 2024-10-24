<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema (
 *     title="Update user password request",
 *     description="Update user password request body data",
 * )
 */
class UpdatePasswordRequest extends FormRequest
{
    /**
     * @OA\Property (
     *     title="password"
     * )
     * @var string
     */
    public $password;

    /**
     * @OA\Property (
     *     title="password_confirm"
     * )
     * @var string
     */
    public $password_confirm;


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
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ];
    }
}
