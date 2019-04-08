<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HorseRaces Model
 *
 * @property \App\Model\Table\RacesTable|\Cake\ORM\Association\BelongsTo $Races
 * @property \App\Model\Table\HorsesTable|\Cake\ORM\Association\BelongsTo $Horses
 *
 * @method \App\Model\Entity\HorseRace get($primaryKey, $options = [])
 * @method \App\Model\Entity\HorseRace newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HorseRace[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HorseRace|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HorseRace saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HorseRace patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HorseRace[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HorseRace findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HorseRacesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('horse_races');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Races', [
            'foreignKey' => 'race_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Horses', [
            'foreignKey' => 'horse_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->decimal('distance')
            ->requirePresence('distance', 'create')
            ->allowEmptyString('distance', false);

        $validator
            ->decimal('running_time')
            ->requirePresence('running_time', 'create')
            ->allowEmptyString('running_time', false);

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['race_id'], 'Races'));
        $rules->add($rules->existsIn(['horse_id'], 'Horses'));
        $rules->add($rules->isUnique(['horse_id','race_id'], 'Horse already in Race'));

        return $rules;
    }

    /**
     * @param \App\Model\Entity\Race $race
     * @param \App\Model\Entity\Horse $horse
     */
    public function addHorseToRace($race, $horse)
    {
        $horseRace = $this->newEntity([
            'horse_id' => $horse->id,
            'race_id' => $race->id,
            'distance' => 0,
            'running_time' => 0,
            'status' => 'pending'
        ]);

        return $this->save($horseRace);
    }

    public function findFinished(Query $query, $options)
    {
        $query->where([
            $query->newExpr()->eq('HorseRaces.status','finished')
        ]);
        return $query;
    }
}
