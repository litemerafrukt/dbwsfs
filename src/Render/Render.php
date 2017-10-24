<?php

namespace litemerafrukt\Render;

use Anax\Page\PageRenderInterface;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Page rendering class.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class Render implements PageRenderInterface, InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Convenience function to render pages in layout
     *
     * @param string
     * @param string
     * @param array
     */
    public function quick($viewFile, $title, $data = [])
    {
        $data = \array_merge(["title" => $title], $data);

        $this->di->get('view')->add($viewFile, $data, "main");

        $this->di->get('pageRender')->renderPage($data);
    }

    /**
     * Render a standard web page using a specific layout.
     *
     * @param array   $data   variables to expose to layout view.
     * @param integer $status code to use when delivering the result.
     *
     * @return void
     */
    public function renderPage($data, $status = 200)
    {
//        $data["stylesheets"] = ["css/style.css"];

        $flash = $this->di->get("flash");
        $view = $this->di->get("view");

        if ($flash->hasMessage()) {
            $view->add("layout/flash", [
                "message" => \htmlspecialchars($flash->message()),
                "class" => $flash->class()
            ], "flash");
        }

        // Add layout, render it, add to response and send.
        $view->add("layout/layout", $data, "layout");
        $body = $view->renderBuffered("layout");

        $this->di->get("response")->setBody($body)->send($status);
        exit;
    }
}
