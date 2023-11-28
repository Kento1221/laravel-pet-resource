<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Domain\Enum\PetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetDataRequest extends FormRequest
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
            'category'  => 'required|integer|exists:categories,id',
            'name'      => 'required|string',
            'photoUrls' => 'required|string',
            'tags.*'    => 'required|integer|exists:tags,id',
            'status'    => [Rule::enum(PetStatus::class)],
        ];
    }
}
