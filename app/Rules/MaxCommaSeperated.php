<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxCommaSeperated implements Rule
{
    
    protected $max;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max)
    {
        $this->max = $max;
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
        
        $count = count(explode(',', $value));
        
        if($count > $this->max)
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
        return ':attribute - Number of selection allowed are '.$this->max;
    }
}
