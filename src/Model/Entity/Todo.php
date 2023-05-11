<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Todo Entity
 *
 * @property int $todo_id
 * @property int $board_id
 * @property int $category_id
 * @property string $content
 * @property \Cake\I18n\FrozenTime|null $deadline_datetime
 * @property \Cake\I18n\FrozenTime|null $created_datetime
 * @property \Cake\I18n\FrozenTime|null $updated_datetime
 * @property \Cake\I18n\FrozenTime|null $delete_datetime
 *
 * @property \App\Model\Entity\Board $board
 * @property \App\Model\Entity\Category $category
 */
class Todo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'board_id' => true,
        'category_id' => true,
        'content' => true,
        'deadline_datetime' => true,
        'created_datetime' => true,
        'updated_datetime' => true,
        'delete_datetime' => true,
        'board' => true,
        'category' => true,
    ];
}
