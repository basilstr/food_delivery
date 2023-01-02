<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Schedule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $key => $el) {
            // перевірка днів тижня
            if($key>0 && $key<8) {
                if ($el) {
                    list($fromStr, $toStr) = explode(' - ', $el);
                    if (($from = strtotime($fromStr)) === false || ($to = strtotime($toStr)) === false) return false;
                    if ($from > $to) return false;
                }
            }
        }
        if(isset($value['start']) && isset($value['finish'])){
            if (($from = strtotime($value['start'])) === false || ($to = strtotime($value['finish'])) === false) return false;
            if ($from > $to) return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('Введений час некоректний');
    }
}
