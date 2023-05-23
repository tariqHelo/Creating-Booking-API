<?php

namespace App\Rules;

use App\Models\Apartment;
use App\Models\Booking;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ApartmentAvailableRule implements ValidationRule
{

    //Protected array $data
    protected array $data = [];
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {


        $apartment = Apartment::find($value);
        if (!$apartment) {
            $fail('Sorry, this apartment is not found');
        }

        if (
            !$apartment->capacity_adults < $this->data['guests_adults']
            || $apartment->capacity_children < $this->data['guests_children']
        ) {
            $fail('Sorry, this apartment does not fit all your guests');
        }


        if (Booking::where('apartment_id', $value)
            ->validForRange([$this->data['start_date'], $this->data['end_date']])
            ->exists()
        ) {
            $fail('Sorry, this apartment is not available for those dates');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     * @return $this
     */

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
