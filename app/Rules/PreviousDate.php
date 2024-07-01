<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PreviousDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        // Convert the input date string to a Carbon instance
        $valueDate = Carbon::createFromFormat('Y-m-d', $value);
        dd($valueDate);
        // Get the current date
        $currentDate = Carbon::now();

        // Check if the date of birth is before the current date
        return $valueDate->lt($currentDate);
    }

    public function message()
    {
        return 'The :attribute must be a date before today.';
    }
}
