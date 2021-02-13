<?php

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\I18n\I18n;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    public $entity_name = 'post';
    public $entity_name_plural = 'posts';

    public $table_buttons = [
        'Editar' => [
            'url' => [
                'controller' => 'Posts',
                'action' => 'edit',
                'plugin' => false
            ],
            'options' => [
                'class' => 'button'
            ]
        ],
        'Borrar' => [
            'url' => [
                'controller' => 'Posts',
                'action' => 'delete',
                'plugin' => false
            ],
            'options' => [
                'confirm' => '¿Está seguro de que desea eliminar el post?',
                'class' => 'button'
            ]
        ]
    ];

    public $header_actions = [
        'Añadir post' => [
            'url' => [
                'controller' => 'Posts',
                'plugin' => false,
                'action' => 'add'
            ]
        ],
        'Administrar categorías' => [
            'url' => [
                'controller' => 'Categories',
                'plugin' => false,
                'action' => 'index'
            ]
        ],
        'Administrar tags' => [
            'url' => [
                'controller' => 'Tags',
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
        if ($this->request->is('post')) {
            //recover the keyword
            $keyword = $this->request->getData('keyword');
            //re-send to the same controller with the keyword
            return $this->redirect(['action' => 'index', $keyword]);
        }

        // Paginator
        $settings = $this->paginate;
        // If performing search, there is a keyword
        if ($keyword != null) {
            // Change pagination conditions for searching
            $settings['conditions'] = [
                'OR' => [
                    $this->getName() . '.title LIKE' => '%' . $keyword . '%',
                    $this->getName() . '.description LIKE' => '%' . $keyword . '%'
                ]
            ];
        }

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
        $entity = $this->{$this->getName()}->newEntity();
        if ($this->request->is('post')) {
            $entity = $this->{$this->getName()}->patchEntity($entity, $this->request->getData());

            if ($this->{$this->getName()}->save($entity)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $categories = $this->{$this->getName()}->Categories->find(
            'treelist',
            [
                'spacer' => '&nbsp;&nbsp;'
            ]
        );
        $tags = $this->{$this->getName()}->Tags->find('list');
        $this->set(compact('entity', 'categories', 'tags'));
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
        $entity = $this->{$this->getName()}->get($id, [
            'contain' => ['Tags']
        ]);
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
        $categories = $this->{$this->getName()}->Categories->find(
            'treelist',
            [
                'spacer' => '&nbsp;&nbsp;'
            ]
        );

        $tags = $this->{$this->getName()}->Tags->find('list');
        $this->set(compact('entity', 'categories', 'tags'));
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
        $entity = $this->{$this->getName()}->get($id);
        $this->{$this->getName()}->delete($entity);
        
        return $this->redirect(['action' => 'index']);
    }
}
