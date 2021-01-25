<?php

namespace App\Models\Social\Traits\Method;

use Illuminate\Support\Facades\Storage;

/**
 * Trait ImagesMethod.
 */
trait ImagesMethod
{
    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isPublish()
    {
        return ! $this->is_banned;
    }

    /**
     * @return bool
     */
    public function isBanned()
    {
        return $this->is_banned;
    }

    /**
     * @return Storage
     */
    public function getFile()
    {
        $file_path = sprintf(
            '%s/%s.%s',
            $this->avatar_path,
            $this->avatar_name,
            $this->avatar_type
        );

        return Storage::get($file_path);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $file_path = sprintf(
            '%s/%s.%s',
            $this->avatar_path,
            $this->avatar_name,
            $this->avatar_type
        );

        return storage_path($file_path);
    }

    /**
     * @param bool $size
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getPicture($size = false)
    {
        switch ($this->storage)
        {
            case 'gravatar':
                if (! $size)
                {
                    $size = config('gravatar.default.size');
                }
                // return gravatar()->get($this->email, ['size' => $size]);

            case 'storage':
                return url(sprintf('storage/%s/%s.%s', str_replace('public/', '', $this->avatar_path), $this->avatar_name, $this->avatar_type));
        }

        return false;
    }
}
