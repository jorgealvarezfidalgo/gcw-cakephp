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
        $usuario = $this->{$this->getName()}->Usuarios->newEntity();
        if ($this->request->is('post')) {
			$datos_usuario = array(
				'nombre' => $this->request->getData()['nombre'],
				'apellidos' => $this->request->getData()['apellidos'],
				'email' => $this->request->getData()['email']
			);
			
			
			$usuario_bd = $this->{$this->getName()}->Usuarios->find()->where(['email' => $datos_usuario['email']])->first();
			
			if(is_null($usuario_bd)) {
				$usuario = $this->{$this->getName()}->Usuarios->patchEntity($usuario, $datos_usuario);
				if ($this->{$this->getName()}->Usuarios->save($usuario)) {
					$usuario_bd = $this->{$this->getName()}->Usuarios->find()->where(['email' => $usuario->email])->first();					
				}
			} else {
				$usuario = $usuario_bd;
				$usuario = $this->{$this->getName()}->Usuarios->patchEntity($usuario, $datos_usuario);
				$this->{$this->getName()}->Usuarios->save($usuario);
			}
			
			$datos_contacto = array(
						'usuario_id' => $usuario_bd->id,
						'vehiculo_id' => $id,
						'mensaje' => $this->request->getData()['mensaje']
			);
			$entity = $this->{$this->getName()}->patchEntity($entity, $datos_contacto);
			if($this->{$this->getName()}->save($entity)) {
				$this->Flash->success(__('El contacto se ha realizado exitosamente.'));
			}
			return $this->redirect(['controller' => 'Vehiculos', 'action' => 'index']);
        }
        $this->set(compact('entity', 'modelo', 'marca'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contacto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contacto = $this->Contactos->get($id);
        if ($this->Contactos->delete($contacto)) {
            $this->Flash->success(__('El contacto ha sido eliminado'));
        } else {
            $this->Flash->error(__('El contacto no ha podido ser eliminado. Por favor, inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	

}
