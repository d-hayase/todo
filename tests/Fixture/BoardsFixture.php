<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BoardsFixture
 */
class BoardsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'board_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'created_datetime' => '2023-05-16 02:37:35',
                'updated_datetime' => '2023-05-16 02:37:35',
                'delete_datetime' => '2023-05-16 02:37:35',
            ],
        ];
        parent::init();
    }
}
