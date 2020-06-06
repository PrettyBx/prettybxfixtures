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
    protected static $faker;

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
    public function make(string $code, array $additional = []): array
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
     * makeMany.
     *
     * @access	public
     * @param	string	$code      	
     * @param	int   	$quantity  	
     * @param	array 	$additional	Default: []
     * @return	array
     */
    public function makeMany(string $code, int $quantity, array $additional = []): array
    {
        $data = [];

        while ($quantity > 0) {
            $data[] = $this->make($code, $additional);

            --$quantity;
        }

        return $data;
    }

    /**
     * getFaker.
     *
     * @access	public
     * @return	Generator
     */
    public static function getFaker(): Generator
    {
        if (empty(static::$faker)) {
            static::$faker = \Faker\Factory::create();
        }

        return static::$faker;
    }
}
