<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyArabic implements Rule
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
        $value = $_POST["name"];
        return preg_match('/^[ء-ي\s]+$/u', $value);
        return true;
       
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return "يجب ادخال اسم باللغة العربية فقط"; 
    }
}
