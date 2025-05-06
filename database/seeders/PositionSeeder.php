<?php

namespace Database\Seeders;

use App\Enums\LevelType;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $positions = [
      [
        'name' => 'Junior Software Developer',
        'description' => 'Responsible for assisting in the development, testing, and maintenance of software applications under the guidance of senior developers.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => ['Basic knowledge of programming languages', 'Understanding of version control systems', 'Eagerness to learn'],
      ],
      [
        'name' => 'Senior Software Developer',
        'description' => 'Leads the design, development, and implementation of software solutions while mentoring junior developers.',
        'level' => LevelType::SENIOR->value,
        'requirements' => ['Proficiency in multiple programming languages', 'Experience with software architecture', 'Strong problem-solving skills'],
      ],
      [
        'name' => 'Expert Software Architect',
        'description' => 'Defines the high-level structure of software systems and ensures alignment with business goals.',
        'level' => LevelType::EXPERT->value,
        'requirements' => ['Extensive experience in software design', 'Deep understanding of system architecture', 'Leadership and strategic thinking'],
      ],
      [
        'name' => 'Junior Data Analyst',
        'description' => 'Assists in collecting, processing, and analyzing data to support business decisions.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => ['Basic knowledge of data analysis tools', 'Understanding of data visualization', 'Attention to detail'],
      ],
      [
        'name' => 'Senior Data Analyst',
        'description' => 'Performs advanced data analysis and provides actionable insights to stakeholders.',
        'level' => LevelType::SENIOR->value,
        'requirements' => ['Proficiency in data analysis tools', 'Experience with statistical modeling', 'Strong communication skills'],
      ],
      [
        'name' => 'Expert Data Scientist',
        'description' => 'Develops complex machine learning models and drives data-driven strategies for the organization.',
        'level' => LevelType::EXPERT->value,
        'requirements' => ['Expertise in machine learning', 'Strong programming skills', 'Ability to handle large datasets'],
      ],
      [
        'name' => 'Junior Project Manager',
        'description' => 'Supports project planning and execution under the supervision of senior project managers.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => ['Basic understanding of project management', 'Good organizational skills', 'Ability to work in a team'],
      ],
      [
        'name' => 'Senior Project Manager',
        'description' => 'Manages complex projects, ensuring they are delivered on time and within budget.',
        'level' => LevelType::SENIOR->value,
        'requirements' => ['Proven project management experience', 'Strong leadership skills', 'Excellent communication abilities'],
      ],
      [
        'name' => 'Expert IT Consultant',
        'description' => 'Provides strategic IT advice to improve business processes and technology infrastructure.',
        'level' => LevelType::EXPERT->value,
        'requirements' => ['Extensive IT consulting experience', 'Deep understanding of business processes', 'Strong analytical skills'],
      ],
      [
        'name' => 'Senior DevOps Engineer',
        'description' => 'Oversees the deployment and maintenance of infrastructure, ensuring smooth CI/CD processes.',
        'level' => LevelType::SENIOR->value,
        'requirements' => ['Experience with cloud platforms', 'Proficiency in CI/CD tools', 'Strong scripting skills'],
      ],
    ];

    foreach ($positions as $position) {
      Position::create($position);
    }
  }
}
