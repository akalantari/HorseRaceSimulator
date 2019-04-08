<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Race Entity
 *
 * @property int $id
 * @property string $status
 * @property float $running_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\HorseRace[] $horse_races
 */
class Race extends Entity
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
        'status' => true,
        'running_time' => true,
        'created' => true,
        'modified' => true,
        'horse_races' => true
    ];

    public function isFinished()
    {
        return $this->status=='finished';
    }

}
