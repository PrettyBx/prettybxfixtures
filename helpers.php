<?php

if (! function_exists('fixture')) {
    function fixture()
    {
        return container()->make(\PrettyBx\Fixtures\FixtureManager::class);
    }
}

if (! function_exists('faker')) {
    function faker()
    {
        return \PrettyBx\Fixtures\FixtureManager::getFaker();
    }
}
