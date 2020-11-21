<?php

namespace App\Tests;

use Silex\WebTestCase as BaseWebTestCase;

abstract class WebTestCase extends BaseWebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        require __DIR__ . '/../config/dev.php';

        return $app;
    }
}
