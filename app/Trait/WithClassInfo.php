<?php

namespace App\Trait;

trait WithClassInfo
{
    public function getClassName()
    {
        return get_class($this);
    }
}
