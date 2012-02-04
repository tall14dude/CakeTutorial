<?php 
echo $this->Form->create(array('action'=>'login'));
echo $this->Form->inputs(array(
	'legend' => 'Login',
	'username',
	'password'));
echo $this->Form->end('Login');
echo $this->Html->link(
	'Register',
	array('controller' => 'users', 'action' => 'add'));
 ?>