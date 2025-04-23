<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
            'name' => 'required',
            'portfolio_id' => 'required|exists:portfolios,id',
            'asset_type_id' => 'required_if_accepted:indexed',
            'indexed' => 'required|boolean',
            'yield_index' => 'required_if_accepted:indexed|exists:yield_index,id',
            'modifier' => 'required_if_accepted:indexed|decimal:0,6',
            'percentage' => 'required_if_declined:indexed|decimal:0,6',
        ];
    }
}
