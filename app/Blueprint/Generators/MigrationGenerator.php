<?php

namespace App\Blueprint\Generators;

use Carbon\Carbon;
use Symfony\Component\Finder\SplFileInfo;
use Blueprint\Generators\MigrationGenerator as BlueprintMigrationGenerator;

class MigrationGenerator extends BlueprintMigrationGenerator
{
    protected function getTablePath($tableName, Carbon $timestamp, $overwrite = false)
    {
        $dir = config('blueprint.app_path') . '/Database/Migrations/';

        if (!$this->filesystem->exists($dir)) {
            $this->filesystem->makeDirectory($dir, 0755, true);
        }

        $name = '_create_' . $tableName . '_table.php';

        if ($overwrite) {
            $migrations = collect($this->filesystem->files($dir))
                ->filter(fn (SplFileInfo $file) => str_contains($file->getFilename(), $name))
                ->sort();

            if ($migrations->isNotEmpty()) {
                $migration = $migrations->first()->getPathname();

                $migrations->diff($migration)
                    ->each(function (SplFileInfo $file) {
                        $path = $file->getPathname();
                        $this->filesystem->delete($path);
                        $this->output['deleted'][] = $path;
                    });

                return $migration;
            }
        }

        return $dir . $timestamp->format('Y_m_d_His') . $name;
    }
}
