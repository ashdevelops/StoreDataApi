<?php declare(strict_types = 1);

namespace App\Controllers;

use App\Interfaces\StoreOpeningHours;
use Carbon\Carbon;

class StoreController implements StoreOpeningHours
{
    // Array key is the day of the week ( 1 - 7)
    // First value of the nested array is the open time
    // Second value of the nested array is the close time

    private static $storeOpeningHoursDayOfWeek = [
        1 => [9, 18], // MONDAY
        2 => [9, 10], // TUESDAY
        3 => [9, 20], // WEDNESDAY
        4 => [9, 21], // THURSDAY
        5 => [9, 21], // FRIDAY
        6 => [9, 15], // SATURDAY
        7 => [13, 16], // SUNDAY
    ];

    public function openingTimes() : array
    {
        return self::$storeOpeningHoursDayOfWeek;
    }

    public function isOpenAt(Carbon $timestamp) : array
    {
        $openingTimes = self::$storeOpeningHoursDayOfWeek[$timestamp->dayOfWeek];

        $openTime = $timestamp->copy()->startOfDay();
        $openTime->hour = $openingTimes[0];

        $closeTime = $timestamp->copy()->startOfDay();
        $closeTime->hour = $openingTimes[1];

        return ['isOpen' => $timestamp > $openTime && $timestamp < $closeTime];
    }

    public function nextOpenFrom(Carbon $timestamp) : array
    {
        $nextIndex = getNextArrayKey(self::$storeOpeningHoursDayOfWeek, $timestamp->dayOfWeek);

        $nextOpeningDay = $timestamp->startOfDay()->next($nextIndex);

        $nextOpeningHours = self::$storeOpeningHoursDayOfWeek[$nextIndex];
        $nextOpeningHour = $nextOpeningHours[0];

        return ['nextOpen' => $nextOpeningDay->setHour($nextOpeningHour)];
    }
}