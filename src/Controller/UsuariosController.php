<?php

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\I18n\I18n;

/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 */
class UsuariosController extends AppController
{
    public $entity_name = 'usuario';
    public $entity_name_plural = 'usuarios';

    public $table_buttons = [
        'Borrar' => [
            'url' => [
                'controller' => 'Usuarios',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar el usuario?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
		'Administrar contactos' => [
            'url' => [
                'controller' => 'Contactos',
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
     * @return \Cake\Network\Response|null
     */
    public function index($keyword = null)
    {
        // Paginator
        $settings = $this->paginate;
        //prepare the pagination
        $this->paginate = $settings;
        $entities = $this->paginate($this->modelClass);

        $this->set('entities', $entities);
        $this->set('keyword', $keyword);
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
        $entity = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
            $entity = $this->Usuarios->patchEntity($entity, $this->request->getData());
            if ($this->Usuarios->save($entity)) {
                $this->Flash->success(__('El usuario ha sido guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no pudo ser guardado. Inténtelo de nuevo.'));
        }
        $this->set(compact('entity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
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
     * @param string|null $id Post id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
		$contacto = $this->{$this->getName()}->Contactos->find()->where(['usuario_id' => $id])->first();
		if($contacto) {
			$this->Flash->error(__('Existe al menos un contacto con este usuario asignado, por lo que no puede ser eliminado.'));
			return $this->redirect(['action' => 'index']);
		}
        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success(__('El usuario ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El usuario no pudo ser eliminado. Inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
