<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Region;

class RegionName implements Rule
{
    private $input;

    private $id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($input = [], $id = NULL)
    {
        $this->input = $input;
        $this->id = $id;
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
        //-- update
        if ($this->id) {
            return !Region::where('id', '!=', $this->id)
                          ->where('parent_id', $this->input->parent_id)
                          ->whereRaw("LOWER($attribute) = ?", [$value])
                          ->exists();
        }
        //-- create
        else {
            return !Region::where('parent_id', $this->input->parent_id)
                          ->whereRaw("LOWER($attribute) = ?", [$value])
                          ->exists();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute already exists.';
    }
}
