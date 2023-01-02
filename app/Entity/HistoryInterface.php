<?php


namespace App\Entity;


interface HistoryInterface
{
    public static function parseHistory($change_params);
}
