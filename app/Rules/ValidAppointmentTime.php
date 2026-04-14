<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class ValidAppointmentTime implements ValidationRule
{
    protected $doctorId;

    public function __construct($doctorId)
    {
        $this->doctorId = $doctorId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->doctorId) {
            return;
        }

        try {
            $date = Carbon::parse($value);
            $dayOfWeek = $date->format('l'); // Returns 'Monday', 'Tuesday', etc.
            $time = $date->format('H:i:s');

            // Check the database to see if the doctor actually works at this time
            $schedule = DoctorSchedule::where('doctor_id', $this->doctorId)
                ->where('day_of_week', $dayOfWeek)
                ->where(function($query) {
                    $query->where('is_available', true)->orWhere('is_available', 1);
                })
                ->where('start_time', '<=', $time)
                ->where('end_time', '>=', $time)
                ->first();

            if (!$schedule) {
                $fail("The selected time is outside Dr. {$this->doctorId}'s available clinic schedule.");
            }
        } catch (\Exception $e) {
            $fail('The provided appointment date and time is invalid.');
        }
    }
}