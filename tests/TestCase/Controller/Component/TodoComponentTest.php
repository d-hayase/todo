<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\TodoComponent;
use App\Model\Entity\Board;
use App\Model\Entity\Category;
use App\Model\Entity\Todo;
use App\Test\Factory\BoardFactory;
use App\Test\Factory\CategoryFactory;
use App\Test\Factory\TodoFactory;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use CakephpFixtureFactories\Scenario\ScenarioAwareTrait;
use Exception;

/**
 * App\Controller\Component\TodoComponent Test Case
 */
class TodoComponentTest extends TestCase
{
    use ScenarioAwareTrait;

    /**
     * Test subject
     *
     * @var \App\Controller\Component\TodoComponent
     */
    protected $Todo;

    protected $fixtures = [
        'app.Boards',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Todo = new TodoComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Todo);

        parent::tearDown();
    }

    /**
     * Test getBoards method
     * ・ 正常系
     *
     * @return void
     */
    public function testGetBoards(): void
    {
        // ボードの登録
        $params = [
            'Boards' => [
                'params' => [
                    'name' => 'ボード1',
                ],
            ],
            'Todo' => [
                'association' => 'withHighPriorityTodo',
                'params' => [
                    'content' => 'Todo1',
                ],
            ],
        ];

        $board = BoardFactory::make($params['Boards']['params'])->withTodo($params)->persist();

        // ボード情報の取得
        $boards = $this->Todo->getBoards();

        // ボード情報の検証
        $this->assertSame(1, count($boards));

        $board = $boards[0];
        $this->assertTrue($board instanceof Board);
        $this->assertSame('ボード1', $board->name);
        $this->assertNull($board->delete_datetime);

        $todo = $board->todo[0];
        $this->assertTrue($todo instanceof Todo);
        $this->assertSame('Todo1', $todo->content);
        $this->assertNull($todo->delete_datetime);

        $category = $todo->category;
        $this->assertTrue($category instanceof Category);
        $this->assertSame('優先度高', $category->text);
    }

    /**
     * Test addBoard method
     * ・ 正常系
     *
     * @return void
     */
    public function testAddBoardSuccess(): void
    {
        // ボード情報の登録
        $addBoard = $this->Todo->addBoard(['name' => 'test addBoard']);

        // ボード情報の登録確認
        $boardsTable = TableRegistry::getTableLocator()->get('Boards');
        $addedBoard = $boardsTable->findByBoardId($addBoard->board_id)->first();
        $this->assertSame($addBoard->board_id, $addedBoard->board_id);
    }

    /**
     * Test addTodo method
     * ・ 正常系
     *
     * @return void
     */
    public function testAddTodoSuccess(): void
    {
        // Todoの登録
        $addTodo = $this->Todo->addTodo([
            'boardId' => 1,
            'categoryId' => 1,
            'content' => 'name',
        ]);

        // Todoの登録確認
        $todoTable = TableRegistry::getTableLocator()->get('Todo');
        $addedTodo = $todoTable->findByTodoId($addTodo->todo_id)->first();
        $this->assertSame($addTodo->todo_id, $addedTodo->todo_id);
    }

    /**
     * Test addTodo method
     * ・ 異常系 / ボードIDが存在しない
     *
     * @return void
     */
    public function testAddTodoNotExistBoardId(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('存在しないボードです。');

        // Todoの登録
        $this->Todo->addTodo([
            'boardId' => 99999, // 存在しないボードID
            'categoryId' => 1,
            'content' => 'name',
        ]);
    }

    /**
     * Test addTodo method
     * ・ 異常系 / カテゴリIDが存在しない
     *
     * @return void
     */
    public function testAddTodoNotExistCategoryId(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('存在しないカテゴリです。');

        // Todoの登録
         $this->Todo->addTodo([
            'boardId' => 1,
            'categoryId' => 99999, // 存在しないカテゴリID
            'content' => 'name',
        ]);
    }

    /**
     * Test deleteBoard method
     * ・ 正常系
     *
     * @return void
     */
    public function testDeleteBoard(): void
    {
        // ボードの登録
        $board = BoardFactory::make(['name' => 'テストボード'])->persist();

        // ボードの登録確認
        $boardsTable = TableRegistry::getTableLocator()->get('Boards');
        $registerdboard = $boardsTable->findByBoardId($board->board_id)->first();
        $this->assertNull($registerdboard->delete_datetime);

        // ボードの削除
        $this->Todo->deleteBoard($registerdboard->board_id);

        // ボードの削除確認
        $deletedboard = $boardsTable->findByBoardId($registerdboard->board_id)->first();
        $this->assertNotNull($deletedboard->delete_datetime);
    }

    /**
     * Test deleteTodo method
     * ・ 正常系
     *
     * @return void
     */
    public function testDeleteTodo(): void
    {
        // Todo登録
        $todo = TodoFactory::make([
            'board_id' => 1,
            'category_id' => 1,
            'content' => 'テストボード'
        ])->persist();

        // Todoの登録確認
        $todoTable = TableRegistry::getTableLocator()->get('Todo');
        $registerdTodo = $todoTable->findByTodoId($todo->todo_id)->first();
        $this->assertNull($registerdTodo->delete_datetime);

        // Todoの削除
        $this->Todo->deleteTodo($registerdTodo->todo_id);

        // Todoの削除確認
        $deletedTodo = $todoTable->findByTodoId($registerdTodo->todo_id)->first();
        $this->assertNotNull($deletedTodo->delete_datetime);
    }

    /**
     * Test formatBoards method
     * ・ 正常系
     *
     * @return void
     */
    public function testFormatBoards(): void
    {
        // ボードの登録
        $params= [
            'Boards' => [
                'params' => [
                    'board_id' => 1,
                    'name' => 'ボード1'
                ],
            ],
            'Todo' => [
                'params' => [
                    'board_id' => 1,
                    'category_id' => 1,
                    'content' => 'Todo1',
                    'deadline_datetime' => new FrozenTime('2023-01-01 00:00:00'),
                ],
            ],
            'Categories' => [
                'params' => [
                    'category_id' => 1,
                    'text' => 'カテゴリ1',
                ],
            ],
        ];
        $board = BoardFactory::make($params['Boards']['params'])->withTodo($params)->getEntity();

        $expected = [
            [
                'boardId' => 1,
                'name' => 'ボード1',
                'tasks' => [
                    [
                        'content' => 'Todo1',
                        'deadlineDatetime' => new FrozenTime('2023-01-01 00:00:00'),
                        'category' => [
                            'categoryId' => 1,
                            'categoryName' => 'カテゴリ1',
                        ],
                        'isDeleted' => false,
                    ],
                ],
            ],
        ];
        $formatted = $this->Todo->formatBoards([$board]);
        $this->assertSame(json_encode($expected), json_encode($formatted));
    }
}
