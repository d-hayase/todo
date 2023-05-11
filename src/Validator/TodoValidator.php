<?php
declare(strict_types=1);

namespace App\Validator;

use Cake\Validation\Validator;

/**
 * Todo validator
 */
class TodoValidator extends Validator
{
    public const BOARD_MAX_LENGTH = 100;
    public const TODO_MAX_LENGTH = 100;

    /**
     * addBoard Validator
     *
     * @return \Cake\Validation\Validator
     */
    public function addBoard(): Validator
    {
        $this->requirePresence('name', true)
            ->notEmptyString('name')
            ->maxLength('name', self::BOARD_MAX_LENGTH);

        return $this;
    }

    /**
     * addTodo Validator
     *
     * @return \Cake\Validation\Validator
     */
    public function addTodo(): Validator
    {
        $this->requirePresence('boardId', true)
            ->nonNegativeInteger('boardId');

        $this->requirePresence('categoryId', true)
            ->nonNegativeInteger('categoryId');

        $this->requirePresence('content', true)
            ->notEmptyString('content')
            ->maxLength('content', self::TODO_MAX_LENGTH);

        $this->requirePresence('deadlineDatetime', false)
            ->notEmptyDateTime('deadlineDatetime');

        return $this;
    }
}
