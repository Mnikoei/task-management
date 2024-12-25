<?php

namespace App\Services\Utils\ModelsSupport;

use App\Http\Filters\BaseQueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    public function scopeFilter(Builder $builder, BaseQueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
