<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * TodoControllerTest class
 *
 * @uses \App\Controller\TodoController
 */
class TodoControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $fixtures = [
        'app.Boards',
        'app.Categories',
    ];

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test list method
     * ・ 正常系
     *
     * @return void
     */
    public function testListSuccess(): void
    {
        $this->get('/tasks');
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['boards']));
    }

    /**
     * Test addBoard method
     * ・ 正常系
     *
     * @return void
     */
    public function testAddBoardSuccess(): void
    {
        $requestBody = ['name' => 'ボード1'];
        $this->post('/tasks/board', $requestBody);
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['isSuccess']));
    }

    /**
     * Test addBoard method
     * ・ 異常系 / バリデーションエラー
     *
     * @return void
     */
    public function testAddBoardValidationError(): void
    {
        $requestBody = [];
        $this->post('/tasks/board', $requestBody);
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseCode(422);
        $this->assertSame($body['errorMessage'], '不正なリクエストです。');
    }

    /**
     * Test addTodo method
     * ・ 正常系
     *
     * @return void
     */
    public function testAddTodoSuccess(): void
    {
        $requestBody = [
            'boardId' => 1,
            'categoryId' => 1,
            'content' => 'Todo1',
        ];
        $this->post('/tasks/todo', $requestBody);
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['isSuccess']));
    }

    /**
     * Test addTodo method
     * ・ 異常系 / バリデーションエラー
     *
     * @return void
     */
    public function testAddTodoValidationError(): void
    {
        $requestBody = [];
        $this->post('/tasks/todo', $requestBody);
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseCode(422);
        $this->assertSame($body['errorMessage'], '不正なリクエストです。');
    }

    /**
     * Test deleteBoard method
     * ・ 正常系
     *
     * @return void
     */
    public function testDeleteBoardSuccess(): void
    {
        $this->delete('/tasks/board/1');
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['isSuccess']));
    }

    /**
     * Test deleteBoard method
     * ・ 正常系 / 存在しないIDを指定した場合
     *
     * @return void
     */
    public function testDeleteBoardNotExistId(): void
    {
        $this->delete('/tasks/board/99999');
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['isSuccess']));
    }

    /**
     * Test deleteTodo method
     * ・ 正常系
     *
     * @return void
     */
    public function testDeleteTodoSuccess(): void
    {
        $this->delete('/tasks/todo/1');
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['isSuccess']));
    }

    /**
     * Test deleteTodo method
     * ・ 正常系 / 存在しないIDを指定した場合
     *
     * @return void
     */
    public function testDeleteTodoNotExistId(): void
    {
        $this->delete('/tasks/todo/99999');
        $body = json_decode((string)$this->_response->getBody(), true);

        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseOk();
        $this->assertTrue(isset($body['isSuccess']));
    }
}
