<?php

namespace Dawnstar\MediaManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FolderRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'private' => ['required', 'boolean'],
            'name' => [
                'required',
                Rule::unique('folders')->ignore($this->folder)
            ]
        ];
    }

    public function attributes()
    {
        return __('folder.labels');
    }
}
