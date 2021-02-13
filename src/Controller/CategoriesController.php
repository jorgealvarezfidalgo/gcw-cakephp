<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    public $entity_name = 'categoría';
    public $entity_name_plural = 'categorías';

    public $table_buttons = [
        'Editar' => [
            'url' => [
                'controller' => 'Categories',
                'action' => 'edit',
                'plugin' => false
            ],
            'options' => [
                'class' => 'button'
            ]
        ],
        'Borrar' => [
            'url' => [
                'controller' => 'Categories',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar la categoría?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
        'Añadir categoría' => [
            'url' => [
                'controller' => 'Categories',
                'plugin' => false,
                'action' => 'add'
            ]
        ]
    ];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $entities = $this->{$this->getName()}->find('all')
            ->order(['lft' => 'ASC']);

        $this->set('entities', $entities);
        $this->set('entities_count', $entities->count());

        $this->set('header_actions', $this->header_actions);
        $this->set('table_buttons', $this->table_buttons);
        $this->set('_serialize', 'entities');
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
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
        $categories = $this->{$this->getName()}->find(
            'treelist',
            [
                'spacer' => '&nbsp;&nbsp;'
            ]
        );

        $this->set(compact('entity', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
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
                        'action' => 'edit',
                        $entity->id,
                        $locale
                    ]
                );
            }
        }
        $categories = $this->{$this->getName()}->find(
            'treelist',
            [
                'spacer' => '&nbsp;&nbsp;'
            ]
        );
        $this->set(compact('entity', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $entity = $this->{$this->getName()}->get($id);
        $this->{$this->getName()}->delete($entity);

        return $this->redirect(['action' => 'index']);
    }
}
