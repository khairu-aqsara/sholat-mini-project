<?php

namespace Khairu\Sholat;

/**
 * Base controller class for rendering views.
 */
class Controller
{
    /**
     * Renders a view with optional data.
     *
     * @param string $view The name of the view file (without the .php extension).
     * @param array $data Optional data to be passed to the view.
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        include "Views/{$view}.php";
    }
}
