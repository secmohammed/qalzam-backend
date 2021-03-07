<?php

namespace Tests;

use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Styde\Enlighten\Tests\EnlightenSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, EnlightenSetup, RefreshDatabase;

    /**
     * @param $class
     * @param $name
     */
    public function factoryWithoutObservers($class, $name = 'default')
    {
        $class::flushEventListeners();

        return factory($class, $name);
    }

    /**
     * @param JWTSubject $user
     * @param $method
     * @param $endpoint
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function jsonAs(JWTSubject $user, $method, $endpoint, $data = [], $headers = [])
    {
        $token = auth('api')->tokenById($user->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer ' . $token,
        ]));
    }

    protected function setUp(): void
    {
        parent::setUp();
        if (in_array(now()->dayName, ['Saturday', 'Friday'])) {
            Carbon::setTestNow(now()->addDays(2));
        }
        $this->setUpEnlighten();
    }
}
