<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $topics = [
      [
        'name' => 'Employee Performance',
        'description' => 'Evaluation of an employee’s ability to meet job expectations and deliver results effectively.'
      ],
      [
        'name' => 'Employee Behavior',
        'description' => 'Assessment of an employee’s conduct, attitude, and interpersonal skills in the workplace.'
      ],
      [
        'name' => 'Business Metrics',
        'description' => 'Analysis of key performance indicators that measure the success and efficiency of business operations.'
      ],
      [
        'name' => 'Customer Satisfaction',
        'description' => 'Measurement of how products or services meet or exceed customer expectations.'
      ],
      [
        'name' => 'Productivity',
        'description' => 'Evaluation of the efficiency and output of employees or teams in achieving organizational goals.'
      ],
    ];


    foreach ($topics as $topic) {
      Topic::create($topic);
    }
  }
}
