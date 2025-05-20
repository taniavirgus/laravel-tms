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
        'name' => 'Junior HR Specialist',
        'description' => 'Assists in the recruitment process, onboarding new employees, and maintaining employee records, while supporting senior HR staff in daily operations and ensuring compliance with company policies.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => [
          'Basic understanding of HR principles and labor laws',
          'Strong interpersonal and communication skills',
          'Attention to detail and organizational abilities'
        ],
      ],
      [
        'name' => 'Senior HR Manager',
        'description' => 'Leads the human resources department by developing and implementing HR strategies, managing complex employee relations issues, and ensuring the organization adheres to all legal and regulatory requirements.',
        'level' => LevelType::SENIOR->value,
        'requirements' => [
          'Extensive experience in HR management',
          'In-depth knowledge of employment law',
          'Proven leadership and conflict resolution skills'
        ],
      ],
      [
        'name' => 'Junior Financial Analyst',
        'description' => 'Supports the finance team by collecting and analyzing financial data, preparing basic reports, and assisting with budgeting and forecasting activities under the supervision of senior analysts.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => [
          'Basic knowledge of accounting and finance principles',
          'Proficiency in spreadsheet software',
          'Analytical thinking and attention to detail'
        ],
      ],
      [
        'name' => 'Senior Accountant',
        'description' => 'Manages complex accounting tasks, oversees financial reporting, ensures compliance with regulations, and provides guidance to junior finance staff.',
        'level' => LevelType::SENIOR->value,
        'requirements' => [
          'Professional accounting certification (e.g., CPA)',
          'Strong knowledge of financial regulations and reporting standards',
          'Experience with financial analysis and budgeting'
        ],
      ],
      [
        'name' => 'Marketing Coordinator',
        'description' => 'Coordinates marketing campaigns, assists in content creation, and supports the marketing team in executing strategies to increase brand awareness and customer engagement.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => [
          'Basic understanding of marketing principles',
          'Strong written and verbal communication skills',
          'Creativity and attention to detail'
        ],
      ],
      [
        'name' => 'Senior Marketing Strategist',
        'description' => 'Develops and leads comprehensive marketing strategies, analyzes market trends, and manages high-impact campaigns to drive business growth and brand recognition.',
        'level' => LevelType::SENIOR->value,
        'requirements' => [
          'Proven experience in marketing strategy development',
          'Strong analytical and project management skills',
          'Expertise in digital marketing and market research'
        ],
      ],
      [
        'name' => 'IT Support Specialist',
        'description' => 'Provides technical support to employees, troubleshoots hardware and software issues, and assists in maintaining the company’s IT infrastructure.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => [
          'Basic knowledge of computer systems and networks',
          'Problem-solving skills',
          'Customer service orientation'
        ],
      ],
      [
        'name' => 'Senior Systems Administrator',
        'description' => 'Oversees the management and security of the company’s IT systems, implements upgrades, and ensures high availability and reliability of technology resources.',
        'level' => LevelType::SENIOR->value,
        'requirements' => [
          'Extensive experience with system administration',
          'Strong knowledge of network and server management',
          'Ability to troubleshoot complex technical issues'
        ],
      ],
      [
        'name' => 'Operations Assistant',
        'description' => 'Supports daily operational activities, coordinates logistics, and helps maintain efficient workflows within the operations department.',
        'level' => LevelType::JUNIOR->value,
        'requirements' => [
          'Organizational and multitasking skills',
          'Attention to detail',
          'Ability to work collaboratively in a fast-paced environment'
        ],
      ],
      [
        'name' => 'Operations Manager',
        'description' => 'Leads the operations team, optimizes business processes, ensures quality control, and manages resources to achieve organizational goals.',
        'level' => LevelType::SENIOR->value,
        'requirements' => [
          'Proven experience in operations management',
          'Strong leadership and decision-making skills',
          'Expertise in process improvement and resource allocation'
        ],
      ],
    ];

    foreach ($positions as $position) {
      Position::create($position);
    }
  }
}
