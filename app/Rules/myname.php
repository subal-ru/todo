<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class myname implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        //検査値
        $this->value = $value;
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
        if ($value == session('name')) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->value . 'は自分のアカウント名です.<br>招待したいアカウント名を入力してください.';
        // return trans('validation.myname');
    }
}
