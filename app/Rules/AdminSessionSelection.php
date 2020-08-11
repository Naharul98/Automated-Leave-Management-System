<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AdminSessionSelection implements Rule
{

    protected $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        //
        $this->request = $param;
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
        return ($value == 'admin' && $this->request->input('session_choices') == null) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Regular admin must be in charge of at least 1 session';
    }
}
