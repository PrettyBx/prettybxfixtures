<?php

if (! function_exists('fixture')) {
    function fixture(string $code, array $additional = [])
    {
        return container()->make(\PrettyBx\Fixtures\FixtureManager::class)->fixture($code, $additional);
    }
}

if (! function_exists('faker')) {
    function faker()
    {
        return container()->make(\PrettyBx\Fixtures\FixtureManager::class)->getFaker();
    }
}
