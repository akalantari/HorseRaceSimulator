<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HorseRacesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HorseRacesTable Test Case
 */
class HorseRacesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HorseRacesTable
     */
    public $HorseRaces;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.HorseRaces',
        'app.Races',
        'app.Horses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HorseRaces') ? [] : ['className' => HorseRacesTable::class];
        $this->HorseRaces = TableRegistry::getTableLocator()->get('HorseRaces', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HorseRaces);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
