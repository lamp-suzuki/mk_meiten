<?php

// 電話番号の国際化
function toInternational($number)
{
    if (preg_match('/^[0-9]+$/', $number) && (strlen($number) == 10 || strlen($number) == 11)) {
        return preg_replace('/^0/', '+81', $number);
    } elseif (preg_match('/^\+81[0-9]+$/', $number) && (strlen($number) == 12 || strlen($number) == 13)) {
        return $number;
    } else {
        return false;
    }
}

// 電話番号の地域番号化
function toDomestic($number)
{
    if (preg_match('/^\+81[0-9]+$/', $number) && (strlen($number) == 12 || strlen($number) == 13)) {
        return preg_replace('/^\+81/', '0', $number);
    } elseif (preg_match('/^[0-9]+$/', $number) && (strlen($number) == 10 || strlen($number) == 11)) {
        return $number;
    } else {
        return false;
    }
}
