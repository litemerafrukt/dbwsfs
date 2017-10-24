<?php
namespace litemerafrukt\Controllers;

use litemerafrukt\Utils\InjectionAwareClass;

class TagsController extends InjectionAwareClass
{
    /**
     * Insert toptags into layout
     */
    public function toptags()
    {
        $toptags = $this->di->tagModel->toptags();
        $this->di->get('view')->add('layout/tagbar', \compact('toptags'), 'tagbar');
    }

    /**
     * Tag page
     */
    public function index()
    {
        $tags = $this->di->tagModel->toptags(100000);
        $this->di->get('pageRender')->quick('tags/tags', "Taggar", \compact('tags'));
    }
}
