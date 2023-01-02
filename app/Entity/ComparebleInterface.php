<?php


namespace App\Entity;


interface ComparebleInterface
{
    public function hasDiff($data);
    public function toArray();
}
