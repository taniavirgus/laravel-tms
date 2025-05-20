<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\Employee;
use App\Enums\ApprovalType;
use App\Enums\StatusType;

class EvaluationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = array_to_object([
      [
        'department_id' => 1,
        'position_id' => 1,
        'evaluations' => [
          [
            'name' => 'Employee Onboarding Effectiveness',
            'description' => 'Measures the effectiveness of onboarding new employees by assessing their productivity, engagement, and retention within the first 90 days.',
            'point' => 10,
            'target' => 100,
            'weight' => 30,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 1
          ],
          [
            'name' => 'Workplace Conduct',
            'description' => 'Assesses employee adherence to company policies, professional behavior, and collaboration within the HR department.',
            'point' => 8,
            'target' => 90,
            'weight' => 25,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 2
          ],
        ]
      ],
      [
        'department_id' => 2,
        'position_id' => 3,
        'evaluations' => [
          [
            'name' => 'Budget Accuracy',
            'description' => 'Measures accuracy of budget forecasts vs actual spending by comparing planned budgets to actual expenditures over a fiscal period.',
            'point' => 10,
            'target' => 95,
            'weight' => 35,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 3
          ],
          [
            'name' => 'Financial Reporting Timeliness',
            'description' => 'Evaluates the punctuality of monthly and annual financial report submissions.',
            'point' => 7,
            'target' => 100,
            'weight' => 20,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 5
          ],
        ]
      ],
      [
        'department_id' => 3,
        'position_id' => 5,
        'evaluations' => [
          [
            'name' => 'Campaign ROI',
            'description' => 'Measures return on investment for marketing campaigns by calculating the ratio of net profit to the cost of the campaign.',
            'point' => 12,
            'target' => 120,
            'weight' => 40,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 3
          ],
          [
            'name' => 'Customer Engagement Score',
            'description' => 'Assesses the effectiveness of marketing in engaging customers through surveys and interaction metrics.',
            'point' => 10,
            'target' => 85,
            'weight' => 30,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 4
          ],
        ],
      ],
      [
        'department_id' => 4,
        'position_id' => 6,
        'evaluations' => [
          [
            'name' => 'System Uptime',
            'description' => 'Measures percentage of time systems are operational by tracking system availability and downtime over a specific period.',
            'point' => 10,
            'target' => 99,
            'weight' => 35,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 3
          ],
          [
            'name' => 'Ticket Resolution Time',
            'description' => 'Evaluates average time to resolve support tickets by analyzing the time taken from ticket creation to resolution.',
            'point' => 8,
            'target' => 85,
            'weight' => 30,
            'status' => ApprovalType::DRAFT->value,
            'topic_id' => 5
          ],
          [
            'name' => 'Security Compliance',
            'description' => 'Assesses adherence to IT security policies and successful completion of security audits.',
            'point' => 9,
            'target' => 100,
            'weight' => 25,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 2
          ],
        ]
      ],
      [
        'department_id' => 5,
        'position_id' => 8,
        'evaluations' => [
          [
            'name' => 'Operational Efficiency',
            'description' => 'Measures overall operational efficiency by evaluating resource utilization, process optimization, and output quality.',
            'point' => 15,
            'target' => 95,
            'weight' => 40,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 5
          ],
          [
            'name' => 'Quality Control Pass Rate',
            'description' => 'Tracks the percentage of products or services passing quality checks on the first attempt.',
            'point' => 10,
            'target' => 98,
            'weight' => 30,
            'status' => ApprovalType::APPROVED->value,
            'topic_id' => 3
          ],
        ]
      ]
    ]);

    foreach ($data as $item) {
      $department = Department::find($item->department_id);
      if (!$department) continue;

      foreach ($item->evaluations as $evaluation) {

        $evaluation = Evaluation::create([
          'name' => $evaluation->name,
          'description' => $evaluation->description,
          'point' => $evaluation->point,
          'target' => $evaluation->target,
          'weight' => $evaluation->weight,
          'status' => $evaluation->status,
          'topic_id' => $evaluation->topic_id,
          'department_id' => $item->department_id,
          'position_id' => $item->position_id,
        ]);

        if ($evaluation->status !== ApprovalType::APPROVED) continue;

        $employees = Employee::where('department_id', $department->id)
          ->where('position_id', $item->position_id)
          ->where('status', StatusType::ACTIVE)
          ->get();

        if ($employees->isEmpty()) continue;

        foreach ($employees as $employee) {
          $min = (int)($evaluation->target * 0.6);
          $max = $evaluation->target;

          $score = rand($min, $max);

          $evaluation->employees()->attach($employee->id, [
            'score' => $score,
            'created_at' => now(),
            'updated_at' => now(),
          ]);
        }
      }
    }
  }
}
