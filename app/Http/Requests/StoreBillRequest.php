<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        // acesso à família já é garantido pelo middleware EnsureFamilyAccess
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'direction' => ['required', 'in:PAYABLE,RECEIVABLE'],
        ];
    }
}
