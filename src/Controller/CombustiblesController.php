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
class CombustiblesController extends AppController
{
	
	public $entity_name = 'combustible';
    public $entity_name_plural = 'combustibles';
	
	public $table_buttons = [
		'Editar' => [
				'url' => [
					'controller' => 'Combustibles',
					'action' => 'edit',
					'plugin' => false
				],
				'options' => [
					'class' => 'button'
				]
			],
        'Borrar' => [
            'url' => [
                'controller' => 'Combustibles',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar el combustible?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
		'Añadir combustible' => [
				'url' => [
					'controller' => 'Combustibles',
					'plugin' => false,
					'action' => 'add'
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
        $entity = $this->Combustibles->newEntity();
        if ($this->request->is('post')) {
            $entity = $this->Combustibles->patchEntity($entity, $this->request->getData());
            if ($this->Combustibles->save($entity)) {
                $this->Flash->success(__('El combustible ha sido guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El combustible no pudo ser guardado. Inténtelo de nuevo.'));
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
        $combustible = $this->Combustibles->get($id);
        if ($this->Combustibles->delete($combustible)) {
            $this->Flash->success(__('El combustible ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El combustible no pudo ser eliminado. Inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
