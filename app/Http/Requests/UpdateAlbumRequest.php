<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|min:3|max:30',
            'slug' => 'string|min:3|max:30|unique:albums,slug',
            'description' => 'nullable|string|max:1000',
            'event_date' => 'date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Der Titel muss ein String sein',
            'title.min' => 'Der Titel muss mindestens 3 Zeichen lang sein!',
            'title.max' => 'Der Titel darf maximal 30 Zeichen lang sein!',
            'slug.string' => 'Der Slug muss ein String sein',
            'slug.min' => 'Der Slug muss minimal 3 Zeichen lang sein!',
            'slug.max' => 'Der Slug darf maximal 30 Zeichen lang sein!',
            'slug.unique' => 'Der Slug ist bereits vergeben!',
            'description.string' => 'Die Beschreibung muss eine String sein',
            'description.max' => 'Die Beschreibung darf maximal 1000 Zeichen lang sein!',
            'event_date.date' => 'Das Veranstaltungsdatum muss ein Datum sein!'
        ];
    }

}
