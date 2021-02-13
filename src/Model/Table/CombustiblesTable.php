<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Combustibles Model
 *
 * @property \App\Model\Table\VehiculosTable&\Cake\ORM\Association\HasMany $Vehiculos
 *
 * @method \App\Model\Entity\Combustible get($primaryKey, $options = [])
 * @method \App\Model\Entity\Combustible newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Combustible[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Combustible|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Combustible saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Combustible patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Combustible[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Combustible findOrCreate($search, callable $callback = null, $options = [])
 */
class CombustiblesTable extends Table
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

        $this->setTable('combustibles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Vehiculos', [
            'foreignKey' => 'combustible_id',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 255)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre');

        return $validator;
    }
}
