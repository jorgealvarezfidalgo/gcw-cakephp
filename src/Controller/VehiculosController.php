<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Vehiculos Controller
 *
 * @property \App\Model\Table\VehiculosTable $Vehiculos
 *
 * @method \App\Model\Entity\Vehiculo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VehiculosController extends AppController
{
	
	public $entity_name = 'vehiculo';
    public $entity_name_plural = 'vehiculos';

    public $table_buttons_admin = [
        'Editar' => [
            'url' => [
                'controller' => 'Vehiculos',
                'action' => 'edit',
                'plugin' => false
            ],
            'options' => [
                'class' => 'button'
            ]
        ],
        'Borrar' => [
            'url' => [
                'controller' => 'Vehiculos',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar el vehículo?',
                'class' => 'button'
            ]
        ]
    ];
	
	public $table_buttons = [
        'Ver' => [
            'url' => [
                'controller' => 'Vehiculos',
                'action' => 'view',
                'plugin' => false
            ],
            'options' => [
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
        'Añadir vehículo' => [
            'url' => [
                'controller' => 'Vehiculos',
                'plugin' => false,
                'action' => 'add'
            ]
        ],
        'Administrar modelos' => [
            'url' => [
                'controller' => 'Modelos',
                'plugin' => false,
                'action' => 'index'
            ]
        ],
        'Administrar combustibles' => [
            'url' => [
                'controller' => 'Combustibles',
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
        $this->common_index();
		
		$this->set('header_actions', []);
        $this->set('table_buttons', $this->table_buttons);
        $this->set('_serialize', 'entities');
    }
	
	public function admin()
    {
        $this->common_index();
		
        $this->set('header_actions', $this->header_actions);
        $this->set('table_buttons', $this->table_buttons_admin);
        $this->set('_serialize', 'entities');
    }
	
	private function common_index() {
		$settings = $this->paginate;

        //prepare the pagination
        $this->paginate = $settings;
        $entities = $this->paginate($this->modelClass);
		
		$modelos = $this->{$this->getName()}->Modelos->find()
			->combine('id', 'nombre')
			->toArray();
			
		$combustibles = $this->{$this->getName()}->Combustibles->find()
			->combine('id', 'nombre')
			->toArray();
			
		$marcas = $this->{$this->getName()}->Modelos->Marcas->find()
			->combine('id', 'nombre')
			->toArray();
			
		$marcas_modelos = $this->{$this->getName()}->Modelos->find()
			->combine('id', 'marca_id')
			->toArray();

        $this->set('entities', $entities);
        $this->set('modelos', $modelos);
        $this->set('combustibles', $combustibles);
        $this->set('marcas', $marcas);
        $this->set('marcas_modelos', $marcas_modelos);
	}

    /**
     * View method
     *
     * @param string|null $id Vehiculo id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$view_actions = [
			'Contactar para este vehículo' => [
				'url' => [
					'controller' => 'Contactos',
					'plugin' => false,
					'action' => 'add'
				]
			]
		];
		$this->set('header_actions', $view_actions);
        $entity = $this->{$this->getName()}->get($id);
		$modelos = $this->Vehiculos->Modelos->find('list', ['limit' => 200]);
        $combustibles = $this->Vehiculos->Combustibles->find('list', ['limit' => 200]);
        $this->set(compact('entity', 'modelos', 'combustibles'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $entity = $this->{$this->getName()}->newEntity();
        if ($this->request->is('post')) {
            $entity = $this->{$this->getName()}->patchEntity($entity, $this->request->getData());

            if ($this->{$this->getName()}->save($entity)) {
                return $this->redirect(['action' => 'admin']);
            }
        }
        $modelos = $this->{$this->getName()}->Modelos->find('list');
        $combustibles = $this->{$this->getName()}->Combustibles->find('list');
        $this->set(compact('entity', 'modelos', 'combustibles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vehiculo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null, $locale = null)
    {
        if ($locale != null) {
            $this->setLocale($locale);
        }
        $entity = $this->{$this->getName()}->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $entity = $this->{$this->getName()}->patchEntity($entity, $this->request->getData());
            if ($this->{$this->getName()}->save($entity)) {
                return $this->redirect(
                    [
                        'action' => 'admin'
                    ]
                );
            }
        }
        $modelos = $this->Vehiculos->Modelos->find('list', ['limit' => 200]);
        $combustibles = $this->Vehiculos->Combustibles->find('list', ['limit' => 200]);
        $this->set(compact('entity', 'modelos', 'combustibles'));
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
            $this->Flash->success(__('El vehículo ha sido eliminado'));
        } else {
            $this->Flash->error(__('El vehículo no ha podido ser eliminado. Por favor, inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'admin']);
    }
	

}
