<?php

namespace Nulltex\Paginator\Tests;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class PaginatorTest extends TestCase
{
    protected const ITEMS_TOTAL = 100;

    protected const ITEMS_PER_PAGE = 10;

    protected const CURRENT_PAGE = 10;

    protected const DEFAULT_OPTIONS = ['pageName' => 'page', 'path' => '/path'];

    protected function createDefaultPaginator(array $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, [
            'items' => Collection::make(),
            'total' => self::ITEMS_TOTAL,
            'perPage' => self::ITEMS_PER_PAGE,
            'currentPage' => self::CURRENT_PAGE,
            'options' => $options,
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();

        Route::get('/one', static function () {
            return 'One';
        })->name('test.one');
        Route::get('/two/{page}', static function () {
            return 'Two';
        })->name('test.two');
        Route::get('/three/{page?}', static function () {
            return 'Three';
        })->name('test.three');
        Route::get('/four/{param}/{page?}', static function () {
            return 'Four';
        })->name('test.four');
        Route::get('/five/{alias}/{page?}', static function () {
            return 'Five';
        })->name('test.five');
    }

    /** @test */
    public function setup_paginator(): void
    {
        $paginator = $this->createDefaultPaginator(self::DEFAULT_OPTIONS)->setRoute(['test.one']);

        $this->assertEquals(\Nulltex\Paginator\Paginator::class, get_class($paginator));
        $this->assertIsArray($paginator->getRoute());
        $this->assertEmpty($paginator->setRoute()->getRoute());
    }

    /** @test */
    public function default_url_generation(): void
    {
        $paginator = $this->createDefaultPaginator([
            'path' => '/new',
            'pageName' => 'p',
            'query' => ['foo' => 'bar'],
        ]);

        $this->assertEquals('/new?foo=bar&p=1', $paginator->url(0));
    }

    /** @test */
    public function routed_url_generation(): void
    {
        $paginator = $this->createDefaultPaginator([
            'path' => '/another',
            'pageName' => 'page',
            'query' => ['param' => 'some'],
        ]);

        $this->assertEquals(
            URL::route('test.one', ['param' => 'some', 'page' => 2]),
            $paginator->setRoute(['test.one'])->setRouteAbsoluteUrl(true)->url(2)
        );
        $this->assertEquals(
            '/one?param=some&page=3',
            $paginator->setRoute(['test.one'])->setRouteAbsoluteUrl(false)->url(3)
        );
        $this->assertEquals(
            '/two/4?param=some',
            $paginator->setRoute(['test.two'])->url(4)
        );
        $this->assertEquals(
            '/three/5?param=some',
            $paginator->setRoute(['test.three'])->url(5)
        );
        $this->assertEquals(
            '/four/some/6',
            $paginator->setRoute(['test.four'])->url(6)
        );
        $this->assertEquals(
            '/five/unique/7?param=some',
            $paginator->setRoute(['test.five', ['alias' => 'unique']])->url(7)
        );
        $this->assertEquals(
            '/one?param=some&page=8#hash',
            $paginator->setRoute(['test.one'])->fragment('hash')->url(8)
        );
    }
}
