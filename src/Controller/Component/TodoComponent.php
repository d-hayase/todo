<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Board;
use App\Model\Entity\Category;
use App\Model\Entity\Todo;
use Cake\Controller\Component;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Exception;

/**
 * Todo component
 */
class TodoComponent extends Component
{
    /**
     * タスク情報の取得
     *
     * @return \App\Model\Entity\Board[] $boards ボードEntities
     */
    public function getBoards(): array
    {
        $boardsTable = TableRegistry::getTableLocator()->get('Boards');
        $boards = $boardsTable->find()
            ->contain([
                'Todo',
                'Todo.Categories',
            ])
            ->where([
                'Boards.delete_datetime IS' => null,
            ])
            ->all()
            ->toArray();

        return $boards;
    }

    /**
     * ボードの追加
     *
     * @param array $requests リクエスト
     * @return \App\Model\Entity\Board $board Board Entity
     */
    public function addBoard(array $requests): Board
    {
        $boardsTable = TableRegistry::getTableLocator()->get('Boards');

        $board = $boardsTable->newEntity([
            'name' => $requests['name'],
        ]);
        $boardsTable->saveOrFail($board);

        return $board;
    }

    /**
     * Todoの追加
     *
     * @param array $requests リクエスト
     * @return \App\Model\Entity\Todo $todo Todo Entity
     */
    public function addTodo(array $requests): Todo
    {
        $boardId = (int)$requests['boardId'];
        $categoryId = (int)$requests['categoryId'];

        if (!$this->existBoard($boardId)) {
            throw new Exception('存在しないボードです。');
        }

        if (!$this->existCategory($categoryId)) {
            throw new Exception('存在しないカテゴリです。');
        }

        $todoTable = TableRegistry::getTableLocator()->get('Todo');
        $todo = $todoTable->newEntity([
            'board_id' => $boardId,
            'category_id' => $categoryId,
            'content' => $requests['content'],
            'deadline_datetime' => $requests['deadlineDatetime'] ?? null,
        ]);
        $todoTable->saveOrFail($todo);

        return $todo;
    }

    /**
     * ボードの削除
     *
     * @param int $boardId ボードID
     * @return void
     */
    public function deleteBoard(int $boardId): void
    {
        $boardsTable = TableRegistry::getTableLocator()->get('Boards');

        try {
            $board = $boardsTable->findByBoardId($boardId)->firstOrFail();
        } catch (RecordNotFoundException $e) {
            return; // 対応するレコードがなければ削除せず終了
        }

        $board = $boardsTable->patchEntity($board, [
            'delete_datetime' => new FrozenTime(),
        ]);
        $boardsTable->saveOrFail($board);
    }

    /**
     * Todoの削除
     *
     * @param int $todoId TodoId
     * @return void
     */
    public function deleteTodo(int $todoId): void
    {
        $boardsTable = TableRegistry::getTableLocator()->get('Todo');

        try {
            $board = $boardsTable->findByTodoId($todoId)->firstOrFail();
        } catch (RecordNotFoundException $e) {
            return; // 対応するレコードがなければ削除せず終了
        }

        $board = $boardsTable->patchEntity($board, [
            'delete_datetime' => new FrozenTime(),
        ]);
        $boardsTable->saveOrFail($board);
    }

    /**
     * ボード情報の整形
     *
     * @param \App\Model\Entity\Board[] $boards Board Entities
     * @return array  $formattedBoards 整形済みボード情報
     */
    public function formatBoards(array $boards): array
    {
        $formattedBoards = [];

        foreach ($boards as $board) {
            // TODO情報がcontainされていなければskip
            if (!isset($board->todo)) {
                continue;
            }

            $formattedBoards[] = [
                'boardId' => $board->board_id,
                'name' => $board->name,
                'tasks' => $this->formatTodos($board->todo),
            ];
        }

        return $formattedBoards;
    }

    /**
     * ボードの有無
     *
     * @param int $boardId ボードID
     * @return bool ボードの有無
     */
    private function existBoard(int $boardId): bool
    {
        $boardsTable = TableRegistry::getTableLocator()->get('Boards');

        return $boardsTable->exists(['board_id' => $boardId]);
    }

    /**
     * カテゴリの有無
     *
     * @param int $categoryId カテゴリID
     * @return bool カテゴリの有無
     */
    private function existCategory(int $categoryId): bool
    {
        $categoriesTable = TableRegistry::getTableLocator()->get('Categories');

        return $categoriesTable->exists(['category_id' => $categoryId]);
    }

    /**
     * Todo情報の整形
     *
     * @param \App\Model\Entity\Todo[] $todos Todo Entities
     * @return array  $formattedTodos 整形済みTodo情報
     */
    private function formatTodos(array $todos): array
    {
        $formattedTodos = [];

        foreach ($todos as $todo) {
            $formattedTodos[] = [
                'content' => $todo->content,
                'deadlineDatetime' => $todo->deadline_datetime,
                'category' => $this->formatCategory($todo->category),
                'isDeleted' => $todo->delete_datetime !== null,
            ];
        }

        return $formattedTodos;
    }

    /**
     * カテゴリ情報の整形
     *
     * @param \App\Model\Entity\Category $category Category Entity
     * @return array  $formattedTodos 整形済みカテゴリ情報
     */
    private function formatCategory(Category $category): array
    {
        return [
            'categoryId' => $category->category_id,
            'categoryName' => $category->text,
        ];
    }
}
