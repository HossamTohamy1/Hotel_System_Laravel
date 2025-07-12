<?php

namespace App\Traits;

use App\Models\Scopes\GloblScope;

trait HasGloblScope
{
    protected static function booted()
    {
        static::addGlobalScope(new GloblScope);
    }
    
}
