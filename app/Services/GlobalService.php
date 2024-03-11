<?php

namespace App\Services;

class GlobalService
{
	public function getHeads()
    {
        return DB::table('users')
            ->select('employee_id','last_name','first_name','middle_name','suffix')
            ->where('is_head', 1)
            ->where('id', '!=', 1)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->orderBy('middle_name')
            ->get();
    }

    public function getRoleTypeUsers()
    {
        return DB::table('role_type_users')
            ->select('role_type')
            ->whereNull('is_deleted')
            ->orWhere('is_deleted', 0)
            ->get();
    }
}
