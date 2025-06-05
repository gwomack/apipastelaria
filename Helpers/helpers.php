<?php

if (!function_exists('validate_image')) {
    function validate_image($attribute, $value, $fail) {
        if (is_string($value)) {
            $explode = explode(',', $value);
            if (count($explode) !== 2) {
                $fail('The ' . $attribute . ' field must be a valid base64 image.');
            }

            $mime = str_replace('data:', '', str_replace(';', '', $explode[0]));

            $imageData = base64_decode($explode[1]);
            if (!$imageData) {
                $fail('The ' . $attribute . ' field must be a valid base64 image.');
            }
            $imageInfo = @getimagesizefromstring($imageData);
            if (!$imageInfo) {
                $fail('The ' . $attribute . ' field must be a valid image file.');
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

            $this->files->add(['foto' => $uploadedFile]);
            $this->merge(['foto' => $uploadedFile]);
            $this->convertedFiles = null;
            $value = $uploadedFile;
        }

        if ($value instanceof \Illuminate\Http\UploadedFile) {
            if (!in_array($value->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                $fail('The ' . $attribute . ' field must be a valid image format: image/jpeg or image/png or image/webp.');
            }
        } else {
            $fail('The ' . $attribute . ' field must be a valid image file.');
        }
    }
}
