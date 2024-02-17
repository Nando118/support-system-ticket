<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["required", "string", "min:4", "max:100"],
            "description" => ["required", "string", "min:10"],
            "labels" => ["required"],
            "labels.*" => ["in:bug,question,enhancement"],
            "categories" => ["required"],
            "categories.*" => ["in:uncategorized,billing/payments,technical question"],
            "priority" => ["required"],
            "attachments" => ["nullable"],
            "attachments.*" => ["mimes:jpg,jpeg,png,rar,zip", "max:2048"]
        ];
    }
}
