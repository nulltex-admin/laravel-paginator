<?php

namespace Nulltex\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

/**
 * Class PaginatorServiceProvider.
 */
class PaginatorServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register():void
    {
        $this->app->bind(LengthAwarePaginator::class, Paginator::class);
    }
}
