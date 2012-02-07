<?php
class AppController extends Controller {
	
	public $components = array(
		'Auth' => array(
			'authorize' => 'controller',
			'loginRedirect' => array(
				'admin' => false,
				'controller' => 'users',
				'action' => 'dashboard'
				),
			'autoRedirect' => FALSE,
			'loginError' => 'Invalid account specified',
			'authError' => 'You don\'t have the right permission'
		),
		'Cookie',
		'Session'
	);
	public function beforeFilter(){
		if ($this->Auth->getModel()->hasField('active')){
			$this->Auth->userScope = array('active' => 1);
		}
		if ($this->Auth->user() == NULL) {
			$user = $this->Cookie->read('User');
			if (!empty($user)){
				$user = $this->Auth->getModel()->find('first', array(
					'conditions' => array(
						$this->Auth->fields['username'] => $user[$this->Auth->fields['username']],
						$this->Auth->fields['password'] => $user[$this->Auth->fields['password']]
						),
					'recursive' => -1));
					if ( !empty($user) && $this->Auth->login($user)){
						print_r($user);
						$this->redirect($this->Auth->redirect());
					}
			}
		}
	}
	public function isAuthorized() {
		return true;	
	}
}

?>