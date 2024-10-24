<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema (
 *     title="Update user request",
 *     description="Update user request body data",
 * )
 */
class UpdateUserRequest extends FormRequest
{/**
 * @OA\Property (
 *     title="fist_name"
 * )
 * @var string
 */
    public $first_name;

    /**
     * @OA\Property (
     *     title="last_name"
     * )
     * @var string
     */
    public $last_name;

    /**
     * @OA\Property (
     *     title="email"
     * )
     * @var string
     */
    public $email;

    /**
     * @OA\Property (
     *     title="role_id"
     * )
     * @var int
     */
    public $role_id;

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
            'email' => 'email|unique:users',
        ];
    }
}
