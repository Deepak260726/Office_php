<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumericStringSize implements Rule
{
    
    protected $size;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($size)
    {
        $this->size = $size;
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
        
        if(strlen($value) != $this->size)
          $pass = false;
        
        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute - Number of character(s) should be '.$this->size;
    }
}
