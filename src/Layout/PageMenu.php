<?php

namespace litemerafrukt\Layout;

use litemerafrukt\Utils\InjectionAwareClass;
use Anax\Common\ConfigureInterface;
use Anax\Common\ConfigureTrait;

class PageMenu extends InjectionAwareClass implements ConfigureInterface
{
    use ConfigureTrait;

    public function setup()
    {
        $this->di->get('view')->add('layout/pagemenu', ['routes' => $this->routes()], 'pageMenu');
    }

    /**
     * Routes
     *
     * @return array
     */
    public function routes()
    {
        return array_map(function ($route) {
            return [
                'route' => $this->di->get("url")->create($route['route']),
                'label' => $route['label'],
            ];
        }, $this->config['routes']);
    }

    /**
     * Get routes as json object
     *
     * @return string
     */
    public function asJson()
    {
        return json_encode($this->routes());
    }
}
