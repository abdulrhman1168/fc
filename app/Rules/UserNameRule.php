<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UserNameRule implements Rule
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
        // $value = $_POST["user_name"];
        $value = $_POST['user_name'];

        // return preg_match('/^[\pL\s]+$/u', $value);
        return preg_match('/^[a-zA-Z0-9]+((_|-|\.)?[a-zA-Z0-9])*$/u', $value);
        return true;
       
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return "يجب ادخال اسم صالح"; 
    }
}
