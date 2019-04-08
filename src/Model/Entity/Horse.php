<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Horse Entity
 *
 * @property int $id
 * @property string $name
 * @property float $speed
 * @property float $strength
 * @property float $endurance
 * @property \Cake\I18n\FrozenTime $created
 */
class Horse extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'speed' => true,
        'strength' => true,
        'endurance' => true,
        'created' => true
    ];
}
