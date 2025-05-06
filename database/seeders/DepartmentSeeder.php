<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $departments = [
      [
        'name' => 'Human Resources',
        'description' => 'Responsible for recruiting, training, and managing employee relations, as well as ensuring compliance with labor laws and company policies.'
      ],
      [
        'name' => 'Finance',
        'description' => 'Handles budgeting, financial planning, and analysis, as well as managing company accounts, payroll, and financial reporting.'
      ],
      [
        'name' => 'Marketing',
        'description' => 'Focuses on promoting the company\'s products or services through market research, advertising campaigns, and customer engagement strategies.'
      ],
      [
        'name' => 'Information Technology',
        'description' => 'Manages the company\'s technology infrastructure, including hardware, software, and network systems, to ensure smooth operations and data security.'
      ],
      [
        'name' => 'Operations',
        'description' => 'Oversees the day-to-day activities of the company, ensuring efficient processes, quality control, and timely delivery of products or services.'
      ]
    ];

    foreach ($departments as $department) {
      Department::create($department);
    }
  }
}
