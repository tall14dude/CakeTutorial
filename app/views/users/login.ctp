<?php 
echo $this->Form->create(array('action'=>'login'));
echo $this->Form->inputs(array(
	'legend' => 'Login',
	'username' => array('label' => 'Username/Email'),
	'password',
	'remember' => array('type' => 'checkbox', 'label' => 'Remember Me')
	));
echo $this->Form->end('Login');
echo $this->Html->link(
	'Register',
	array('controller' => 'users', 'action' => 'add'));
 ?>