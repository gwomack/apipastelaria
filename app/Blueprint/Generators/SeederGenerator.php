<?php

namespace App\Blueprint\Generators;

use Blueprint\Contracts\Model as BlueprintModel;
use Blueprint\Generators\SeederGenerator as BlueprintSeederGenerator;

class SeederGenerator extends BlueprintSeederGenerator
{
    protected function getPath(BlueprintModel $blueprintModel): string
    {
        $path = $blueprintModel->name();
        if ($blueprintModel->namespace()) {
            $path = str_replace('\\', '/', $blueprintModel->namespace()) . '/' . $path;
        }

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->makeDirectory($path, 0755, true);
        }

        return config('blueprint.app_path') . '/Database/Seeders/' . $path . 'Seeder.php';
    }
}
