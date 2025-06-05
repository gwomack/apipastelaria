<?php

namespace App\Blueprint\Generators;

use Blueprint\Blueprint;
use Blueprint\Contracts\Model as BlueprintModel;
use Blueprint\Generators\PestTestGenerator as BlueprintPestTestGenerator;

class PestTestGenerator extends BlueprintPestTestGenerator
{
    protected function getPath(BlueprintModel $model): string
    {
        $path = str_replace('\\', '/', Blueprint::relativeNamespace($model->fullyQualifiedClassName()));

        return config('blueprint.app_path') . '/Tests/Feature/' . $path . 'Test.php';
    }
}
