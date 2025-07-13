<?php

namespace App\Traits;

use App\Models\Scopes\GlobalScope;

trait HasGlobalScope
{
    protected static function bootHasGlobalScope()
    {
        static::addGlobalScope(new GlobalScope);
    }
    public function getById($model,$id)
    {
        return $model::find($id);
    }
}
