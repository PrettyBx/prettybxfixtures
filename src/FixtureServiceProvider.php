<?php

declare(strict_types=1);

namespace PrettyBx\Fixtures;

use PrettyBx\Support\Base\AbstractServiceProvider;
use PrettyBx\Support\Filesystem\Manager;

class FixtureServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array $singletons
     */
    protected $singletons = [FixtureManager::class];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        $this->extendFileManager();
    }

    /**
     * Add include method into File Manager
     *
     * @access	protected
     * @return	void
     */
    protected function extendFileManager(): void
    {
        Manager::macro('include', function ($filename) {
            return include $filename;
        });
    }
}
