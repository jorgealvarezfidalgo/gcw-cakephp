<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CombustiblesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CombustiblesTable Test Case
 */
class CombustiblesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CombustiblesTable
     */
    public $Combustibles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Combustibles',
        'app.Vehiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Combustibles') ? [] : ['className' => CombustiblesTable::class];
        $this->Combustibles = TableRegistry::getTableLocator()->get('Combustibles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Combustibles);

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
