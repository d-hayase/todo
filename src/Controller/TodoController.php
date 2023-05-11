<?php
declare(strict_types=1);

namespace App\Controller;

use App\Validator\TodoValidator;
use Exception;

/**
 * Todo Controller
 *
 * @property \App\Controller\Component\JsonComponent $Json
 * @property \App\Controller\Component\TodoComponent $Todo
 */
class TodoController extends AppController
{
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Json');
        $this->loadComponent('Todo');
    }

    /**
     * list method
     *
     * @return void
     */
    public function list(): void
    {
        $boards = $this->Todo->getBoards();
        $boards = $this->Todo->formatBoards($boards);

        $this->Json->setSucceedJson(['boards' => $boards]);
    }

    /**
     * addBoard method
     *
     * @return void
     */
    public function addBoard(): void
    {
        $requests = $this->request->getData();
        $errors = (new TodoValidator())->addBoard()->validate($requests);
        if (count($errors) > 0) {
            throw new Exception('不正なリクエストです。', 422);
        }

        $this->Todo->addBoard($requests);

        $this->Json->setSucceedJson(['isSuccess' => true]);
    }

    /**
     * addTodo method
     *
     * @return void
     */
    public function addTodo(): void
    {
        $requests = $this->request->getData();
        $errors = (new TodoValidator())->addTodo()->validate($requests);
        if (count($errors) > 0) {
            throw new Exception('不正なリクエストです。', 422);
        }

        $this->Todo->addTodo($requests);

        $this->Json->setSucceedJson(['isSuccess' => true]);
    }

    /**
     * deleteBoard method
     *
     * @param int $boardId ボードId
     * @return void
     */
    public function deleteBoard(int $boardId): void
    {
        $this->Todo->deleteBoard($boardId);
        $this->Json->setSucceedJson(['isSuccess' => true]);
    }

    /**
     * deleteTodo method
     *
     * @param int $todoId TodoId
     * @return void
     */
    public function deleteTodo(int $todoId): void
    {
        $this->Todo->deleteTodo($todoId);
        $this->Json->setSucceedJson(['isSuccess' => true]);
    }
}
