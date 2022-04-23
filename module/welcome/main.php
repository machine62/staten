<?php 
class module_welcome extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('staten');
		$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	
		$oView=new _view('welcome::index');
		
		$this->oLayout->add('main',$oView);
	}
			
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}
