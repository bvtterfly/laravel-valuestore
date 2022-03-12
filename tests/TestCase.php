<?php

namespace Bvtterfly\Valuestore\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Bvtterfly\Valuestore\ValuestoreServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ValuestoreServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
