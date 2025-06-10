<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SerialValido implements ValidationRule
{
	/**
	 * Run the validation rule.
	 *
	 * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
	 */
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		if ($value !== env('LOAD_API_KEY')) {
			$fail("El campo $attribute no tiene un serial válido.");
		}
	}
}
