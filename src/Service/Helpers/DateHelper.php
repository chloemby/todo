<?php


namespace App\Service\Helpers;


use DateTime;
use Throwable;


/**
 * Сервис-помощник для работы с датами
 *
 * Class DateHelper
 * @package App\Services\Helpers
 */
class DateHelper
{
    /**
     * Является ли строка с датой валидной в заданном формате
     *
     * @param string $dateTime Строка с датой
     * @param string $format Формат даны(например, Y-m-d H:i:s)
     * @return bool
     */
    public static function isDateStringValidFormat(string $dateTime, string $format = 'Y-m-d H:i:s'): bool
    {
        try {
            $dateTime = DateTime::createFromFormat($format, $dateTime);
            if (!$dateTime) {
                return false;
            }
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }
}