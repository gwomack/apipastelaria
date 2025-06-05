<?php

namespace Modules\Product\Rules;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class MyImage implements ValidationRule
{
    public $request;

    public function __construct(FormRequest &$request)
    {
        $this->request = $request; // get the request
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
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

            $this->request->files->add(['foto' => $uploadedFile]);
            $this->request->merge(['foto' => $uploadedFile]);
            $this->request->convertedFile = null;
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
