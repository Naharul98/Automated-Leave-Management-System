<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NewAdminRegistrationSessionInCharge implements Rule
{
    protected $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        //
        $this->data = $param;
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
        return ($this->data['role'] == 'admin' && array_key_exists('session_choices', $this->data) == false) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Regular admin must be in charge of at least 1 session.';
    }
}
