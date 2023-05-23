<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BoardsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BoardsTable Test Case
 */
class BoardsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BoardsTable
     */
    protected $Boards;

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
        $config = $this->getTableLocator()->exists('Boards') ? [] : ['className' => BoardsTable::class];
        $this->Boards = $this->getTableLocator()->get('Boards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Boards);

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
