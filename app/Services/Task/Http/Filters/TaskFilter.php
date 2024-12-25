<?php

namespace App\Services\Task\Http\Filters;

use App\Http\Filters\BaseQueryFilter;
use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends BaseQueryFilter
{
    protected $filters = [
        'title',
        'description',
        'due_date',
        'status'
    ];

    // @todo this should be based on full-text search or using search engines in practice
    public function title(string $value): Builder
    {
        return $this->builder->where(
            column: 'title',
            operator: 'like',
            value: "%$value%"
        );
    }

    public function description(string $value): Builder
    {
        return $this->builder->where(
            column: 'description',
            operator: 'like',
            value: "%$value%"
        );
    }

    public function due_date(string $value): Builder
    {
        return $this->builder->where(
            column: 'due_date',
            operator: '<',
            value: $value
        );
    }

    public function status(string $status): Builder
    {
        return $this->builder->where(
            column: 'status',
            operator: '=',
            value: $status
        );
    }
}
