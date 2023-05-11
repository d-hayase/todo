<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesFixture
 */
class CategoriesFixture extends TestFixture
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
                'category_id' => 1,
                'text' => 'Lorem ipsum dolor sit amet',
                'created_datetime' => '2023-05-16 02:37:35',
                'updated_datetime' => '2023-05-16 02:37:35',
                'delete_datetime' => '2023-05-16 02:37:35',
            ],
        ];
        parent::init();
    }
}
