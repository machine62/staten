<?php

class module_live extends abstract_module {

    public function before() {
        $this->oLayout = new _layout('staten');
        $this->oLayout->addModule('menu', 'menu::index');
    }

    public function _list() {

        $oView = new _view('live::list');

        $this->oLayout->add('main', $oView);
    }

    public function after() {
        $this->oLayout->show();
    }

}
