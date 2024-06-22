<?php

namespace App\Services;

class Filesystem extends \Illuminate\Filesystem\Filesystem
{
    private const LARAVEL_FILESYSTEM_DIR_PERMISSIONS = 0755;

    /**
     * @param $mode
     * @return int
     */
    private function swapMode($mode): int
    {
        $defaultDirPermissions = config('filesystems.default_dir_permissions', self::LARAVEL_FILESYSTEM_DIR_PERMISSIONS);

        if ($mode !== $defaultDirPermissions) {
            $mode = $defaultDirPermissions;
        }

        return $mode;
    }

    /**
     * @inheritdoc
     */
    public function ensureDirectoryExists($path, $mode = self::LARAVEL_FILESYSTEM_DIR_PERMISSIONS, $recursive = true)
    {
        parent::ensureDirectoryExists($path, $this->swapMode($mode), $recursive);
    }

    /**
     * @inheritdoc
     */
    public function makeDirectory($path, $mode = self::LARAVEL_FILESYSTEM_DIR_PERMISSIONS, $recursive = false, $force = false)
    {
        return parent::makeDirectory($path, $this->swapMode($mode), $recursive, $force);
    }
}
