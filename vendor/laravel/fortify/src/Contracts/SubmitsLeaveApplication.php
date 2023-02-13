<?php

namespace Laravel\Fortify\Contracts;

interface SubmitsLeaveApplication
{
    /**
     * 
     *
     * @param  array  $input
     * @return mixed
     */
    public function create(array $input);
}
