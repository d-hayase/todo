<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $category_id
 * @property string $text
 * @property \Cake\I18n\FrozenTime|null $created_datetime
 * @property \Cake\I18n\FrozenTime|null $updated_datetime
 * @property \Cake\I18n\FrozenTime|null $delete_datetime
 */
class Category extends Entity
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
        'text' => true,
        'created_datetime' => true,
        'updated_datetime' => true,
        'delete_datetime' => true,
    ];
}
