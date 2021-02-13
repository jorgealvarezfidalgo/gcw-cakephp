<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Combustibles Controller
 *
 * @property \App\Model\Table\CombustiblesTable $Combustibles
 *
 * @method \App\Model\Entity\Combustible[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModelosController extends AppController
{
	
	public $entity_name = 'modelo';
    public $entity_name_plural = 'modelos';
	
	public $table_buttons = [
		'Editar' => [
				'url' => [
					'controller' => 'Modelos',
					'action' => 'edit',
					'plugin' => false
				],
				'options' => [
					'class' => 'button'
				]
			],
        'Borrar' => [
            'url' => [
                'controller' => 'Modelos',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar el modelo?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
		'Añadir modelo' => [
				'url' => [
					'controller' => 'Modelos',
					'plugin' => false,
					'action' => 'add'
				]
			],
			'Administrar marcas' => [
            'url' => [
                'controller' => 'Marcas',
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
        // Paginator
        $settings = $this->paginate;
        //prepare the pagination
        $this->paginate = $settings;
        $entities = $this->paginate($this->modelClass);
		
		$marcas = $this->{$this->getName()}->Marcas->find()
			->combine('id', 'nombre')
			->toArray();

        $this->set('entities', $entities);
        $this->set('marcas', $marcas);
        $this->set('header_actions', $this->header_actions);
        $this->set('table_buttons', $this->table_buttons);
        $this->set('_serialize', 'entities');
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
                return $this->redirect(['action' => 'index']);
            }
        }
		
		$marcas = $this->{$this->getName()}->Marcas->find()
			->combine('id', 'nombre')
			->toArray();
	
        $this->set(compact('entity', 'marcas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Combustible id.
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
                        'action' => 'index'
                    ]
                );
            }
        }
        $marcas = $this->{$this->getName()}->Marcas->find()
			->combine('id', 'nombre')
			->toArray();
        $this->set(compact('entity', 'marcas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Combustible id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modelos = $this->Modelos->get($id);
        if ($this->Modelos->delete($modelos)) {
            $this->Flash->success(__('El modelo ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El modelo no pudo ser eliminado. Inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
