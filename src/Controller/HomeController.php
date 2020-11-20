<?php

namespace App\Controller;

use Twig\Environment;

class HomeController
{
    protected Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        return $this->twig->render('home.twig');
    }
}
