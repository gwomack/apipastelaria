<?php

namespace Modules\Product\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    /**
     * This method prepares file instante
     */
    protected function prepareForValidation($fieldName = 'foto')
    {
        $value = $this->input($fieldName);

        if (is_string($value)) {
            $explode = explode(',', $value);

            if (count($explode) !== 2) {
                return;
            }

            $mime = str_replace('data:', '', str_replace(';', '', $explode[0]));

            $imageData = base64_decode($explode[1]);

            if (!$imageData) {
                return;
            }
            $imageInfo = @getimagesizefromstring($imageData);

            if (!$imageInfo) {
                return;
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'upload');
            file_put_contents($tempFile, $imageData);

            $uploadedFile = new \Illuminate\Http\UploadedFile(
                $tempFile,
                $mime,
                $mime,
                null,
                true
            );

            $this->files->add([$fieldName => $uploadedFile]);
            $this->merge([$fieldName => $uploadedFile]);
            $this->convertedFiles = null;
            $value = $uploadedFile;
        }
    }
}
