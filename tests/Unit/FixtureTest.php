<?php

namespace PrettyBx\Fixture\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use PrettyBx\Fixtures\FixtureManager;
use PrettyBx\Support\Facades\FileManager;

class FixtureTest extends BaseTestCase
{
    protected $filepath = __DIR__ . '/fake/fixture.php';

    public function setUp(): void
    {
        FileManager::clearResolvedInstances();
    }

    /**
     * @test
     */
    public function fixture_throws_exception_if_file_not_exists()
    {
        FileManager::shouldReceive('exists')->with(__DIR__)->andReturn(true);
        FileManager::shouldReceive('exists')->with($this->filepath)->andReturn(false);

        $this->expectException(\InvalidArgumentException::class);

        $manager = new FixtureManager(__DIR__);
        $manager->fixture('fake.fixture');
    }

    /**
     * @test
     */
    public function fixture_returns_correct_data()
    {
        $expected = ['expected' => 'data'];

        FileManager::shouldReceive('exists')->with(__DIR__)->andReturn(true);
        FileManager::shouldReceive('exists')->with($this->filepath)->andReturn(true);
        FileManager::shouldReceive('include')->with($this->filepath)->andReturn($expected);

        $manager = new FixtureManager(__DIR__);

        $data = $manager->fixture('fake.fixture');

        $this->assertEquals($expected, $data);
    }
}
