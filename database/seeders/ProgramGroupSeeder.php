<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramGroup;

class ProgramGroupSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            // HSC Groups
            ['program' => 'HSC', 'group_name' => 'Science'],
            ['program' => 'HSC', 'group_name' => 'Business'],
            ['program' => 'HSC', 'group_name' => 'Humanities'],

            // Honours Groups
            ['program' => 'Honours', 'group_name' => 'BBA'],
            ['program' => 'Honours', 'group_name' => 'BSA'],
            ['program' => 'Honours', 'group_name' => 'BSS'],

            // Degree Groups
            ['program' => 'Degree', 'group_name' => 'Accounting'],
            ['program' => 'Degree', 'group_name' => 'Management'],
            ['program' => 'Degree', 'group_name' => 'Economics'],
        ];

        foreach ($groups as $group) {
            ProgramGroup::updateOrCreate(
                ['program' => $group['program'], 'group_name' => $group['group_name']],
                ['is_active' => true]
            );
        }
    }
}
