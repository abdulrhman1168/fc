<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyEnglish implements Rule
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
        $value = $_POST["name_en"];
        return preg_match('/^[a-zA-Z0-9\s]*$/u', $value);
        return true;
       
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return "يجب ادخال اسم باللغة الانجليزيه فقط"; 
    }
}
