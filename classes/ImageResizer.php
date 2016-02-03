<?php

namespace OFFLINE\RandomImages\Classes;

use October\Rain\Database\Attach\Resizer;

/**
 * Class ImageResizer
 * @package OFFLINE\RandomImages\Classes
 */
class ImageResizer extends Resizer
{
    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}