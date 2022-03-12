<?php

namespace Bvtterfly\Valuestore\Tests;

use Bvtterfly\Valuestore\ValuestoreServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

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
