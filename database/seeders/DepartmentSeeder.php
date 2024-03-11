<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'CORPORATE AFFAIRS & COMMUNICATION',
            'PEOPLE AND CULTURE',
            'SALES & DISTRIBUTION',
            'FINANCE',
            'MARKETING',
            'AITO',
            'CORPORATE SECURITY',
            'IT',
            'LEGAL',
            'GM, KZ&CAM',
            'ENGINEERING',
            'PRODUCTION',
            'GSC TECHNICAL & FUNCTIONAL TRAINING',
            'ENVIRONMENT HEALTH & SAFETY',
            'MANUFACTURING SERVICES',
            'GLOBAL GSC FACTORY IT',
            'GSC DIGITAL PERFORMANCE ANALYSIS',
            'INTEGRATED WORK SYSTEM',
            'MANUFACTURING OPERATIONS ALMATY',
            'PRODUCT COST',
            'QUALITY DEPARTMENT',
        ];
        foreach ($departments as $department) {
            Department::create([
                'name' => $department
            ]);
        }
    }
}
