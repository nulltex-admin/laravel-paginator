<?php

namespace Nulltex\Paginator\Tests;

use Nulltex\Paginator\PaginatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            PaginatorServiceProvider::class,
        ];
    }
}
