<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RacesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RacesTable Test Case
 */
class RacesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RacesTable
     */
    public $Races;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Races',
        'app.HorseRaces'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Races') ? [] : ['className' => RacesTable::class];
        $this->Races = TableRegistry::getTableLocator()->get('Races', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Races);

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
}
