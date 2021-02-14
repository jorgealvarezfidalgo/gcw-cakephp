<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Marcas Controller
 *
 * @property \App\Model\Table\MarcasTable $Marca
 *
 * @method \App\Model\Entity\Combustible[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MarcasController extends AppController
{
	
	public $entity_name = 'marca';
    public $entity_name_plural = 'marcas';
	
	public $table_buttons = [
		'Editar' => [
				'url' => [
					'controller' => 'Marcas',
					'action' => 'edit',
					'plugin' => false
				],
				'options' => [
					'class' => 'button'
				]
			],
        'Borrar' => [
            'url' => [
                'controller' => 'Marcas',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar la marca?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
		'Añadir marca' => [
				'url' => [
					'controller' => 'Marcas',
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

        $this->set('entities', $entities);
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
        $entity = $this->Marcas->newEntity();
        if ($this->request->is('post')) {
            $entity = $this->Marcas->patchEntity($entity, $this->request->getData());
            if ($this->Marcas->save($entity)) {
                $this->Flash->success(__('La marca ha sido guardada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La marca no pudo ser guardada. Inténtelo de nuevo.'));
        }
        $this->set(compact('entity'));
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
        $this->set(compact('entity'));
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
        $marca = $this->Marcas->get($id);
		$modelo = $this->{$this->getName()}->Modelos->find()->where(['marca_id' => $id])->first();
		if($modelo) {
			$this->Flash->error(__('Existe al menos un modelo con esta marca asignada, por lo que no puede ser eliminada.'));
			return $this->redirect(['action' => 'index']);
		}
        if ($this->Marcas->delete($marca)) {
            $this->Flash->success(__('La marca ha sido eliminada.'));
        } else {
            $this->Flash->error(__('La marca no pudo ser eliminada. Inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
