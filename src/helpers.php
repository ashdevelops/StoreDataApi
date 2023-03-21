<?php declare(strict_types = 1);

use Carbon\Carbon;

function getTimestamp(): Carbon
{
    return isset($_POST['timestamp']) ?
        Carbon::parse($_POST['timestamp']) :
        Carbon::now();
}