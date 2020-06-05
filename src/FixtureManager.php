<?php

declare(strict_types=1);

namespace PrettyBx\Fixtures;

use PrettyBx\Support\Facades\FileManager;
use Faker\Generator;

class FixtureManager
{
    /**
     * @var string $folder
     */
    protected $folder;

    /**
     * @var  $faker
     */
    protected $faker;

    public function __construct(string $folder)
    {
        if (! FileManager::exists($folder)) {
            throw new \InvalidArgumentException('No such folder: ' . $folder);
        }

        $this->folder = $folder;
    }

    /**
     * Returns a fixture
     *
     * @access	public
     * @param	string	$code      	
     * @param	array 	$additional	Default: []
     * @return	array
     */
    public function fixture(string $code, array $additional = []): array
    {
        $code = str_replace('.', '/', $code);

        $path = $this->folder . '/' . $code . '.php';

        if (! FileManager::exists($path)) {
            throw new \InvalidArgumentException('No such fixture: ' . $path);
        }

        $fixture = FileManager::include($path);

        if (! is_array($fixture)) {
            throw new \InvalidArgumentException('Fixture must be a valid array');
        }

        return array_merge($fixture, $additional);
    }

    /**
     * getFaker.
     *
     * @access	public
     * @return	Generator
     */
    public function getFaker(): Generator
    {
        if (empty($this->faker)) {
            $this->faker = \Faker\Factory::create();
        }

        return $this->faker;
    }
}
