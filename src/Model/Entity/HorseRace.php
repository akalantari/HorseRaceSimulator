<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HorseRace Entity
 *
 * @property int $id
 * @property int $race_id
 * @property int $horse_id
 * @property float $distance
 * @property float $running_time
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Race $race
 * @property \App\Model\Entity\Horse $horse
 */
class HorseRace extends Entity
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
        'race_id' => true,
        'horse_id' => true,
        'distance' => true,
        'running_time' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'race' => true,
        'horse' => true
    ];

    public function isFinished()
    {
        return $this->status=='finished';
    }
}
