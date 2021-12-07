<?php

namespace app\base;

trait NewInstanceTrait
{
    /**
     * @param mixed ...$params
     * @return static
     */
    public static function newInstance(...$params): self
    {
        return new static(...$params);
    }
}

