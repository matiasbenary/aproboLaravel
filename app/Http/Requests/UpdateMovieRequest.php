<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string'],
            'release_year' => ['digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'director' => ['string'],
            'description' => ['string', 'max:100000'],
            'genre' => ['array'],
            'cover' => ['image']
        ];
    }
}
