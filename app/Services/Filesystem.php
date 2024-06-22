<?php

namespace App\Services;

class Filesystem extends \Illuminate\Filesystem\Filesystem
{
    private const LARAVEL_FILESYSTEM_DIR_PERMISSIONS = 0755;

    /**
     * @param $mode
     * @param $swap
     * @return int
     */
    private function swapMode($mode, $swap): int
    {
        if (!$swap) {
            return $mode;
        }

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
        parent::ensureDirectoryExists($path, $this->swapMode($mode, func_num_args() < 2), $recursive);
    }

    /**
     * @inheritdoc
     */
    public function makeDirectory($path, $mode = self::LARAVEL_FILESYSTEM_DIR_PERMISSIONS, $recursive = false, $force = false)
    {
        return parent::makeDirectory($path, $this->swapMode($mode, func_num_args() < 2), $recursive, $force);
    }
}
