<?php

namespace App\Blueprint\Generators;

use Blueprint\Contracts\Model as BlueprintModel;
use Blueprint\Generators\FactoryGenerator as BlueprintFactoryGenerator;

class FactoryGenerator extends BlueprintFactoryGenerator
{
    protected function getPath(BlueprintModel $blueprintModel): string
    {
        $path = $blueprintModel->name();
        if ($blueprintModel->namespace()) {
            $path = str_replace('\\', '/', $blueprintModel->namespace()) . '/' . $path;
        }

        return config('blueprint.app_path') . '/Database/Factories/' . $path . 'Factory.php';
    }
}
