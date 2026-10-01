<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotFriday implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = \Carbon\Carbon::parse($value);

        if ($date->isFriday()) {
            $fail('Our office is closed on Fridays. Please select another day.');
        }
    }
}
