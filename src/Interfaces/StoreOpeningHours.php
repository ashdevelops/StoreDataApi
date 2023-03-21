<?php declare(strict_types = 1);

namespace App\Interfaces;

use Carbon\Carbon;

interface StoreOpeningHours
{
    function openingTimes() : array;
    function isOpenAt(Carbon $timestamp) : array;
    function nextOpenFrom(Carbon $timestamp) : array;
}