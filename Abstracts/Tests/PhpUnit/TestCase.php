<?php

namespace Mustang\Core\Abstracts\Tests\PhpUnit;

use Mustang\Core\Traits\HashIdTrait;
use Mustang\Core\Traits\TestCaseTrait;
use Mustang\Core\Traits\TestsTraits\PhpUnit\TestsAuthHelperTrait;
use Mustang\Core\Traits\TestsTraits\PhpUnit\TestsMockHelperTrait;
use Mustang\Core\Traits\TestsTraits\PhpUnit\TestsRequestHelperTrait;
use Mustang\Core\Traits\TestsTraits\PhpUnit\TestsResponseHelperTrait;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use TestCaseTrait;
    use TestsRequestHelperTrait;
    use TestsResponseHelperTrait;
    use TestsMockHelperTrait;
    use TestsAuthHelperTrait;
    use HashIdTrait;
    use LazilyRefreshDatabase;

    /**
     * The base URL to use while testing the application.
     */
    protected string $baseUrl;

    /**
     * Seed the DB on migrations
     */
    protected bool $seed = true;

    /**
     * Setup the test environment, before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Reset the test environment, after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Refresh the in-memory database.
     */
    protected function refreshInMemoryDatabase(): void
    {
        $this->artisan('migrate', $this->migrateUsing());

        // Install Passport Client for Testing
        $this->setupPassportOAuth2();

        $this->app[Kernel::class]->setArtisan(null);
    }

    /**
     * Refresh a conventional test database.
     */
    protected function refreshTestDatabase(): void
    {
        if (!RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:fresh', $this->migrateFreshUsing());
            $this->setupPassportOAuth2();

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
