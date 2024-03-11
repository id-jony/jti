<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver
{
    public function deleting(Department $department) {
        if ($department->employees()->exists()) {
            return false;
        }
    }
}
