<?php declare(strict_types = 1);

use Carbon\Carbon;

function getTimestamp(): Carbon
{
    return isset($_POST['timestamp']) ?
        Carbon::parse($_POST['timestamp']) :
        Carbon::now();
}

function getNextArrayKey(array $array, int $currentKey) : int
{
    $i = $currentKey;

    while ($i < count($array)) {
        $i++;

        if (array_key_exists($i, $array)) {
            return $i;
        }
    }

    return 1;
}