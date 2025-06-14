<?php
// core/Controller.php

class Controller
{
    public function render($view, $data = [])
    {
        $viewFile = APP . '/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            extract($data);
            require_once $viewFile;
        } else {
            echo "View not found: $view";
        }
    }
}
