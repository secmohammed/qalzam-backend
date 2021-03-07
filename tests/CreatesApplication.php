<?php

namespace Tests;

use Illuminate\Testing\TestResponse;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        TestResponse::macro('assertResource', function ($resource) {
            $this->assertJson($resource->response()->getData(true));

            return $this;
        });
        TestResponse::macro('assertCollection', function ($collection) {
            $collection->map(function ($resource) {
                $this->assertJson($resource->response()->getData(true));
            });

            return $this;
        });

        return $app;
    }
}
