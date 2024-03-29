<?php
/**
 * 
 */
class UsersController extends AppController {
	
	/**
	 * This function makes specified functions 
	 * public and accessible to anyone.
	 *
	 * @author  
	 */
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function add(){
		if (!empty($this->data)){
			$this->User->create();
			if ($this->User->save($this->data)){
				$this->Session->setFlash('User created!');
				$this->redirect(array('action'=>'login'));
			}else{
				$this->Session->setFlash('Please correct the errors');
			}
		}
	}
	public function login() {
		if (!empty($this->data) && 
			!empty($this->Auth->data['User']['username']) && 
			!empty($this->Auth->data['User']['password'])) {
				$user = $this->User->find('first',array(
				'conditions'=> array(
					'User.email' => $this->Auth->data['User']['username'],
					'User.password' => $this->Auth->data['User']['password']), 
					'recursive' => -1));
			if(!empty($user) && $this->Auth->login($user)){
				if($this->Auth->autoRedirect){
					$this->redirect($this->Auth->redirect());
				}
			} else {
				$this->Session->setFlash($this->Auth->loginError, $this->Auth->flashElement, array(), 'auth');
			}
		}
		if (!empty($this->data)){
			$userId = $this->Auth->user('id');
			if (!empty($userId)) {
				if(!empty($this->data['User']['remember'])) {
					$user = $this->User->find('first', array(
						'conditions' => array('id' => $userId),
						'recursive' => -1,
						'fields' => array('username', 'password')
						));
						$this->Cookie->write('User',array_intersect_key($user[$this->Auth->userModel], array('username' => null, 'password' => NULL)
						));
				} elseif ($this->Cookie->read('User') != null) {
					$this->Cookie->delete('User');
				}
				$this->redirect($this->Auth->redirect());
			}
		}
	}
	public function logout() {
		if($this->Cookie->read('User') != NULL){
			$this->Cookie->delete('User');
		}
		$this->redirect($this->Auth->logout());
	}
	public function dashboard(){
		
	}
}

?>