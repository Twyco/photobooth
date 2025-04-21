<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:30',
            'description' => 'nullable|string|max:1000',
            'event_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Der Titel ist erforderlich!',
            'title.string' => 'Der Titel muss ein String sein',
            'title.min' => 'Der Titel muss mindestens 3 Zeichen lang sein!',
            'title.max' => 'Der Titel darf maximal 30 Zeichen lang sein!',
            'description.string' => 'Die Beschreibung muss eine String sein',
            'description.max' => 'Die Beschreibung darf maximal 1000 Zeichen lang sein!',
            'event_date.required' => 'Das Veranstaltungsdatum ist erforderlich!',
            'event_date.date' => 'Das Veranstaltungsdatum muss ein Datum sein!',
        ];
    }
}
