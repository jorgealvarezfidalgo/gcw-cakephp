<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contactos Controller
 *
 * @property \App\Model\Table\ContactosTable $Contactos
 *
 * @method \App\Model\Entity\Contacto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContactosController extends AppController
{
	
	public $entity_name = 'contacto';
    public $entity_name_plural = 'contactos';

    public $table_buttons = [
        'Borrar' => [
            'url' => [
                'controller' => 'Contactos',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar el contacto?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
        'Administrar vehículos' => [
            'url' => [
                'controller' => 'Vehiculos',
                'plugin' => false,
                'action' => 'index'
            ]
        ],
        'Administrar usuarios' => [
            'url' => [
                'controller' => 'Usuarios',
                'plugin' => false,
                'action' => 'index'
            ]
        ]
    ];

    // Default pagination settings
    public $paginate = [
        'limit' => 20,
        'order' => [
            'Posts.published_date' => 'DESC',
            'Posts.published_time' => 'DESC'
        ]
    ];
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$settings = $this->paginate;

        //prepare the pagination
        $this->paginate = $settings;
        $entities = $this->paginate($this->modelClass);
		
		$modelos = $this->{$this->getName()}->Vehiculos->Modelos->find()
			->combine('id', 'nombre')
			->toArray();
			
		$marcas = $this->{$this->getName()}->Vehiculos->Modelos->Marcas->find()
			->combine('id', 'nombre')
			->toArray();
			
		$marcas_modelos = $this->{$this->getName()}->Vehiculos->Modelos->find()
			->combine('id', 'marca_id')
			->toArray();
			
		$vehiculos_modelos = $this->{$this->getName()}->Vehiculos->find()
			->combine('id', 'modelo_id')
			->toArray();
		
		$usuarios = $this->{$this->getName()}->Usuarios->find()
			->combine('id', 'email')
			->toArray();

        $this->set('entities', $entities);
        $this->set('modelos', $modelos);
        $this->set('usuarios', $usuarios);
        $this->set('marcas', $marcas);
        $this->set('marcas_modelos', $marcas_modelos);
        $this->set('vehiculos_modelos', $vehiculos_modelos);
		$this->set('header_actions', []);
        $this->set('table_buttons', $this->table_buttons);
        $this->set('_serialize', 'entities');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
		$vehiculo = $this->{$this->getName()}->Vehiculos->find()->where(['id' => $id])->first();
		$modelo = $this->{$this->getName()}->Vehiculos->Modelos->find()->where(['id' => $vehiculo->modelo_id])->first();
		$marca = $this->{$this->getName()}->Vehiculos->Modelos->Marcas->find()->where(['id' => $modelo->marca_id])->first();
		
		
        $entity = $this->{$this->getName()}->newEntity();
        if ($this->request->is('post')) {
			debug($this->request->getData());
        }
        $this->set(compact('entity', 'modelo', 'marca'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vehiculo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vehiculo = $this->Vehiculos->get($id);
        if ($this->Vehiculos->delete($vehiculo)) {
            $this->Flash->success(__('El contacto ha sido eliminado'));
        } else {
            $this->Flash->error(__('El contacto no ha podido ser eliminado. Por favor, inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	

}
