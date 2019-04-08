<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Races Model
 *
 * @property \App\Model\Table\HorseRacesTable|\Cake\ORM\Association\HasMany $HorseRaces
 *
 * @method \App\Model\Entity\Race get($primaryKey, $options = [])
 * @method \App\Model\Entity\Race newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Race[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Race|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Race saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Race patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Race[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Race findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RacesTable extends Table
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

        $this->setTable('races');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('HorseRaces', [
            'foreignKey' => 'race_id'
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
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false);

        $validator
            ->dateTime('running_time')
            ->allowEmptyString('running_time');

        return $validator;
    }

    /**
     * @param int $horsePerRace
     * @return \App\Model\Entity\Race|bool
     */
    public function newRace($horsePerRace)
    {
        /**
         * @var \App\Model\Entity\Race $Race
         */
        $race = $this->newEntity([
            'status' => 'pending'
        ]);
        if( !$this->save($race) ) {
            return false;
        }

        $horses = [];
        for($i=0; $i<$horsePerRace; $i++) {
            /**
             * @var \App\Model\Entity\Horse $horse
             */
            $horse = $this->HorseRaces->Horses->createNewHorse();

            $race->horse_races[] = $this->HorseRaces->addHorseToRace($race, $horse);
        }

        return $race;
    }

    public function findFinished(Query $query, $options)
    {
        $query->where([
            $query->newExpr()->eq('Races.status','finished')
        ]);
        return $query;
    }

    public function findUnFinished(Query $query, $options)
    {
        $query->where([
            $query->newExpr()->notEq('Races.status','finished')
        ]);
        return $query;
    }

    public function findRunning(Query $query, $options)
    {
        $query->where([
            $query->newExpr()->eq('Races.status','running')
        ]);
        return $query;
    }

    public function findPending(Query $query, $options)
    {
        $query->where([
            $query->newExpr()->eq('Races.status','pending')
        ]);
        return $query;
    }

}
