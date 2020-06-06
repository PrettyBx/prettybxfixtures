<?php

declare(strict_types=1);

namespace PrettyBx\Fixtures;

use PrettyBx\Support\Base\AbstractServiceProvider;
use PrettyBx\Support\Filesystem\Manager;
use PrettyBx\Support\Contracts\ConfigurationContract;

class FixtureServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var array $singletons
     */
    protected $singletons = [
        FixtureManager::class => function() {
            return new FixtureManager($this->path);
        }
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        $this->extendFileManager();

        $this->loadPath();
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

    /**
     * Loads fixture path
     *
     * @access	protected
     * @return	void
     */
    protected function loadPath(): void
    {
        $this->path = config('fixture_path');
    }
}
