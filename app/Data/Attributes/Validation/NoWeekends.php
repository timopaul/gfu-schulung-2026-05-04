<?php

namespace App\Data\Attributes\Validation;

use Attribute;
use Carbon\Carbon;
use Closure;
use Spatie\LaravelData\Attributes\Validation\ValidationAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NoWeekends extends ValidationAttribute
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = Carbon::parse($value);

        if ($date->isWeekend()) {
            $fail('Das gewählte Datum für :attribute liegt auf einem Wochenende. Wir schulen nur Mo-Fr.');
        }
    }

    public static function keyword(): string
    {
        return 'no-weekend';
    }

    public static function create(string ...$parameters): static
    {
        return new static(...$parameters);
    }
}
