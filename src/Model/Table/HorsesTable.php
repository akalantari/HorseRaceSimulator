<?php
namespace App\Model\Table;

use App\Lib\HorseRaceSimulatorLib;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Horses Model
 *
 * @method \App\Model\Entity\Horse get($primaryKey, $options = [])
 * @method \App\Model\Entity\Horse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Horse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Horse|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Horse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Horse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Horse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Horse findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HorsesTable extends Table
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

        $this->setTable('horses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('name')
            ->maxLength('name', 32)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->decimal('speed')
            ->requirePresence('speed', 'create')
            ->allowEmptyString('speed', false);

        $validator
            ->decimal('strength')
            ->requirePresence('strength', 'create')
            ->allowEmptyString('strength', false);

        $validator
            ->decimal('endurance')
            ->requirePresence('endurance', 'create')
            ->allowEmptyString('endurance', false);

        return $validator;
    }

    /**
     * @return string
     */
    protected function _randomName()
    {
        $names = file_get_contents(CONFIG.'firstnames.csv');
        $names = array_filter(array_map('trim', explode(PHP_EOL, $names)));
        $randIndex = array_rand($names,1);
        return $names[$randIndex];
    }

    /**
     * returns an array of 3: strength, speed, endurance
     *
     * @return array
     */
    protected function _randomHorseParams()
    {
        $result = [];

        for($i=0; $i<3; $i++) {
            $result[] = mt_rand(0,100)/10.0;
        }

        return $result;
    }

    /**
     * Creates a new random horse with random params of name, strength, speed and endurance
     * Note: Used when creating a new race
     *
     * @return Horse|bool
     */
    public function createNewHorse()
    {
        // Create a random name for the horse
        $name = $this->_randomName();
        if( $count = $this->find('name', ['name'=>$name])->count() ) { // If Existing Before and how many
            $count++;
            $name = $name.' '.HorseRaceSimulatorLib::integerToRoman($count);
        }

        // Create a parameters for the horse
        list($strength, $speed, $endurance) = $this->_randomHorseParams();

        // Add the horse to the database
        $horse = $this->newEntity([
            'name' => $name,
            'strength' => $strength,
            'speed' => $speed,
            'endurance' => $endurance
        ]);
        if( !$this->save($horse) ) {
            debug($horse); die;
            return false;
        }

        return $horse;
    }

    public function findName(Query $query, $options=[])
    {
        if( empty($options['name']) ) {
            $options['name'] = null;
        }
        $query->where([
            $query->newExpr()->or_([
                $query->newExpr()->eq('name', $options['name']),
                $query->newExpr()->like('name', $options['name'].' %'),
            ])
        ]);

        return $query;
    }

}
