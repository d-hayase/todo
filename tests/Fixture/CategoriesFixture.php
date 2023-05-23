<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesFixture
 */
class CategoriesFixture extends TestFixture
{

    public $records = [
        [
            'category_id' => 1,
            'text' => '優先度高',
            'created_datetime' => '2023-01-01 00:00:00',
            'updated_datetime' => '2023-01-01 00:00:00',
            'delete_datetime' => '2023-01-01 00:00:00',
        ],
        [
            'category_id' => 2,
            'text' => '優先度中',
            'created_datetime' => '2023-01-01 00:00:00',
            'updated_datetime' => '2023-01-01 00:00:00',
            'delete_datetime' => '2023-01-01 00:00:00',
        ],
        [
            'category_id' => 3,
            'text' => '優先度低',
            'created_datetime' => '2023-01-01 00:00:00',
            'updated_datetime' => '2023-01-01 00:00:00',
            'delete_datetime' => '2023-01-01 00:00:00',
        ],
    ];
}
