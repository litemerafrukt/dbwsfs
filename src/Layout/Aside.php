<?php

namespace litemerafrukt\Layout;

use litemerafrukt\Utils\InjectionAwareClass;

class Aside extends InjectionAwareClass
{
    /**
     * Setup aside
     */
    public function setup()
    {
        $topUsers = $this->di->get('userCred')->topUsers();
        $this->di->get('view')->add('layout/aside', \compact('topUsers'), 'aside');
    }
}
