<?php

namespace Nulltex\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\URL;

/**
 * Class Paginator.
 */
class Paginator extends LengthAwarePaginator
{
    /**
     * @var array|null Route for generate URLs.
     */
    protected ?array $route = [];

    /**
     * @var bool Should paginator generate (when `$this->route` is set) absolute URLs or not.
     */
    protected bool $routeAbsoluteUrl = false;

    /**
     * Set the route to be used for generate URLs.
     *
     * @param array $route
     *
     * @return self
     */
    public function setRoute(?array $route = []): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get the route to be used for generate URLs.
     *
     * @return array
     */
    public function getRoute(): array
    {
        return $this->route;
    }

    /**
     * Set boolean flag if router should generate absolute URLs.
     *
     * @param bool $absolute
     *
     * @return self
     */
    public function setRouteAbsoluteUrl(bool $absolute): self
    {
        $this->routeAbsoluteUrl = $absolute;

        return $this;
    }

    /**
     * Get boolean flag if router should generate absolute URLs.
     *
     * @return bool
     */
    public function getRouteAbsoluteUrl(): bool
    {
        return $this->routeAbsoluteUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        $parameters = [$this->pageName => $page];

        if (count($this->query) > 0) {
            $parameters = array_merge($this->query, $parameters);
        }

        if ($route = $this->route) {
            $routeName = array_shift($route);
            if ($routeParams = current($route)) {
                $parameters = array_merge($parameters, $routeParams);
            }

            return URL::route($routeName, $parameters, $this->getRouteAbsoluteUrl())
                . $this->buildFragment();
        }

        return parent::url($page);
    }
}
