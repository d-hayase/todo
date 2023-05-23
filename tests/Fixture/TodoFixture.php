<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TodoFixture
 */
class TodoFixture extends TestFixture
{
    public $records = [
        [
            'todo_id' => 1,
            'board_id' => 1,
            'category_id' => 1,
            'content' => 'Lorem ipsum dolor sit amet',
            'deadline_datetime' => '2023-05-16 02:37:38',
            'created_datetime' => '2023-05-16 02:37:38',
            'updated_datetime' => '2023-05-16 02:37:38',
            'delete_datetime' => '2023-05-16 02:37:38',
        ],
    ];
}
