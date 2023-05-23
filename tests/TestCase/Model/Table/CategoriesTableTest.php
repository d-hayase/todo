<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoriesTable Test Case
 */
class CategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoriesTable
     */
    protected $Categories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Categories') ? [] : ['className' => CategoriesTable::class];
        $this->Categories = $this->getTableLocator()->get('Categories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Categories);

        parent::tearDown();
    }

    /**
     * 仮置きのテストコード
     *
     * @return void
     */
    public function testTemporary(): void
    {
        $this->markTestSkipped();
    }
}
