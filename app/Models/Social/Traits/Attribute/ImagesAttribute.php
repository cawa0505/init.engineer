<?php

namespace App\Models\Social\Traits\Attribute;

/**
 * Trait ImagesAttribute.
 */
trait ImagesAttribute
{
    /**
     * @return Storage
     */
    public function getFileAttribute()
    {
        return $this->getFile();
    }

    /**
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->getPath();
    }

    /**
     * @return mixed
     */
    public function getPictureAttribute()
    {
        return $this->getPicture();
    }
}
