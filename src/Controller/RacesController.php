<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Races Controller
 *
 *
 * @method \App\Model\Entity\Race[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 *
 * @property \App\Model\Table\HorsesTable $Horses
 * @property \App\Model\Table\RacesTable $Races
 * @property \App\Model\Table\HorseRacesTable $HorseRaces
 */
class RacesController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Horses');
        $this->loadModel('Races');
        $this->loadModel('HorseRaces');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $races = $this->Races->find('unFinished')
            ->contain(['HorseRaces'=>[
                'sort' => [
                    'HorseRaces.running_time' => 'ASC',
                    'HorseRaces.distance' => 'DESC'
                ],
                'Horses'
            ]])
            ->orderAsc('id')
            ->limit(3)->all();

        // Create list of 5 last races
        $finishedRaces = $this->Races->find('finished')
            ->contain(['HorseRaces'=>[
                'sort' => ['HorseRaces.running_time' => 'ASC'],
                'Horses'
            ]])
            ->orderDesc('modified')
            ->limit(5)->all();

        $bestTime = $this->HorseRaces->find('finished')
            ->contain(['Horses','Races'])
            ->orderAsc('HorseRaces.running_time')->first();

        $this->set(compact('finishedRaces','races', 'bestTime'));
    }

    public function create()
    {
        $race = $this->Races->newRace(8);
        if( $race ) {
            $this->Flash->success('A Race has been created successfully');
        } else {
            $this->Flash->error('An error occurred while creating the race');
        }

        $this->redirect($this->referer());
    }

    public function progress()
    {
        $runningRaces = $this->Races->find('running')
            ->contain([
                'HorseRaces' => [
                    'Horses'
                ]
            ])
            ->toArray();

        if( count($runningRaces) < 3 ) {
            $diff = 3-count($runningRaces);
            $newRaces = $this->Races->find('pending')
                ->contain([
                    'HorseRaces' => [
                        'Horses'
                    ]
                ])->limit($diff)->orderAsc('id')->toArray();
            foreach($newRaces as $race) {
                $race->status = 'running';
                $this->Races->save($race);
                $runningRaces[] = $race;
            }
        }

        foreach($runningRaces as $race) {
            $this->_progressRace($race);
        }

        $this->redirect($this->referer());
    }

    /**
     * @param \App\Model\Entity\Race $race
     */
    protected function _progressRace($race)
    {
        $calculatedTime = 0; // in milliseconds
        do {
            $calculatedTime++;
            $race->running_time += 0.01;

            $finishedHorses = 0;

            foreach( $race->horse_races as &$horseRace ) {
                if( $horseRace->isFinished() ) {
                    $finishedHorses++;
                    continue;
                }

                $horseRace->running_time+=0.01;

                $speed = 5.0 + $horseRace->horse->speed; // initial speed of the horse
                $pastEndurancePoint = ($horseRace->distance/100.0)>$horseRace->horse->endurance;
                if( $pastEndurancePoint ) {
                    $speed -= 5.0*(1.0- (($horseRace->horse->strength*8.0)/100.0) );
                }
                $speed = $speed/100.0;

                $horseRace->distance+=$speed;
                if( $horseRace->distance>=1500 ) {
                    $horseRace->status = 'finished';
                } else {
                    $horseRace->status = 'running';
                }
            }

            if( $finishedHorses == count($race->horse_races) ) {
                $race->status = 'finished';
            }
        } while(!$race->isFinished() && $calculatedTime<1000);

        foreach( $race->horse_races as &$horseRace ) {
            $this->Races->HorseRaces->save($horseRace);
        }

        if( $race->isFinished() ) {
            $this->Flash->success(__('Race #{0} has finished and results are in',[$race->id]));
        }

        $this->Races->save($race);
    }

    public function view($id=null)
    {
        $race = $this->Races->findById($id)
            ->contain([
                'HorseRaces' => [
                    'sort' => [
                        'HorseRaces.running_time' => 'ASC',
                        'HorseRaces.distance' => 'DESC'
                    ],
                    'Horses'
                ]
            ])
            ->first();

        if( !$race ) {
            $this->Flash->error('Race was not found');
            $this->redirect($this->referer());
            return;
        }

        $this->set('race', $race);
    }

}
