<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailsCommaSeperated implements Rule
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
        $pass = true;
        
        $emails = explode(',', str_replace(array(';',':'), ',', $value));
        
        foreach($emails as $email) {
          if(filter_var(trim($email), FILTER_VALIDATE_EMAIL) === false)
            $pass = false;
        }
        
        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute - Emails are not valid.';
    }
}
