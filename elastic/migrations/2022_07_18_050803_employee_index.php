<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class EmployeeIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        $settings = [
            'analysis' => [
                'filter' => [
                    "autocomplete_filter" => [
                        "type" => "edge_ngram",
                        "min_gram" => 3,
                        "max_gram" => 25,
                        "token_chars" => [
                            "letter",
                            "whitespace",
                        ],
                    ],
                ],
                'analyzer' => [
                    "autocomplete" => [
                        "type" => "custom",
                        "tokenizer" => "standard",
                        "filter" => [
                            "lowercase",
                            "autocomplete_filter",
                        ],
                    ],
                    "whitespace_analyzer" => [
                        "type" => "custom",
                        "tokenizer" => "whitespace",
                        "filter" => [
                            "lowercase",
                            "autocomplete_filter",
                        ],
                    ],
                ],
            ],
        ];

        $mapping = [
            "properties" => [
                "employeeId" => [
                    "type" => "integer",
                ],
                "employeeName" => [
                    "type" => "text",
                    "analyzer" => "autocomplete",
                    "fielddata" => true,
                ],
                "employeeEmail" => [
                    "type" => "text",
                ],
                "employeePhoneNo" => [
                    "type" => "text",
                ],
                "employeeJob" => [
                    "type" => "text",
                    "analyzer" => "autocomplete",
                    "fielddata" => true,
                ],
                "emplyeeSalary" => [
                    "type" => "float",
                ],
                "employeeDepartment" => [
                    "type" => "text",
                    "analyzer" => "whitespace_analyzer",
                    "fielddata" => true,
                ],
                "employeeAddress" => [
                    "type" => "text",
                    "analyzer" => "autocomplete",
                    "fielddata" => true,
                ],
                "employeeGender" => [
                    "type" => "text",
                    "fielddata" => true,
                ],
                "employeeMartialStatus" => [
                    "type" => "text",
                    "fielddata" => true,
                ],
                "employeeReligion" => [
                    "type" => "text",
                    "fielddata" => true,
                ],
                "employeeImage" => [
                    "type" => "text",
                ],
                "employeePayrolls" => [
                    "properties" => [
                        "performanceBonus" => [
                            "type" => "float",
                        ],
                        "bonus" => [
                            "type" => "integer",
                        ],
                        "transportationCost" => [
                            "type" => "integer",
                        ],
                        "medicalCost" => [
                            "type" => "integer",
                        ],
                        "grossPay" => [
                            "type" => "float",
                        ],
                        "date" => [
                            "type" => "date",
                            'format' => 'yyyy-MM-dd HH:mm:ss'
                        ],
                    ],
                ],
            ],
        ];

        Index::createRaw('employee_index', $mapping, $settings);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('employee_index');
    }
}
