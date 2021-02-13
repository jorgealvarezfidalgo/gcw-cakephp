<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VehiculosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VehiculosTable Test Case
 */
class VehiculosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VehiculosTable
     */
    public $Vehiculos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Vehiculos',
        'app.Modelos',
        'app.Combustibles',
        'app.Contactos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Vehiculos') ? [] : ['className' => VehiculosTable::class];
        $this->Vehiculos = TableRegistry::getTableLocator()->get('Vehiculos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Vehiculos);

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
