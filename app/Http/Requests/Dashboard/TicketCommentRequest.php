<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TicketCommentRequest extends FormRequest
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
            "ticket_id" => ["required"],
            "description" => ["required", "string", "min:10"],
            "attachments" => ["nullable"],
            "attachments.*" => ["mimes:jpg,jpeg,png,rar,zip", "max:2048"]
        ];
    }
}
