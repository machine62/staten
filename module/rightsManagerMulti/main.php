<?php

/*
  examplemodule
 * 
  model_examplemodel
  row_examplemodel
  oExamplemodel
 * 
  exampleGroupId
  exampleActionId
  exampleItemId

  exampleUser_groupsId
 * */

class module_rightsManagerMulti extends abstract_module {

    public function before() {
        //redirection si non auorisé:

        if (!_root::getACL()->can('access', 'rightsManagerMulti'))
        {
            _root::redirect('default::index');
            die();
        }

        $this->oLayout = new _layout('staten');
        $this->oLayout->addModule('menu', 'menu::index');
    }

    public function _index() {
        $this->_list();
    }

    public function _list() {
        $tPermission = model_rightsManagerMulti::getInstance()->findAll();

        $oView = new _view('rightsManagerMulti::index');
        $oView->tPermission = $tPermission;

        $tUser = model_rightsManagerMulti::getInstance()->findListUser();
        $oView->tUser = $tUser;

        $oView->tJoinGroup = model_rightsManagerMulti::getInstance()->findSelectGroup();

        $this->oLayout->add('main', $oView);
    }

    public function _edit() {

        $tMessage = $this->processEdit();

        $oPermission = model_rightsManagerMulti::getInstance()->findById(_root::getParam('id'));
        $oView = new _view('rightsManagerMulti::edit');
        $oView->oPermission = $oPermission;

        $oPluginXsrf = new plugin_xsrf();
        $oView->token = $oPluginXsrf->getToken();
        $oView->tMessage = $tMessage;

        $oView->tJoinGroup = model_rightsManagerMulti::getInstance()->findSelectGroup();
        $oView->tJoinAction = model_rightsManagerMulti::getInstance()->findSelectAction();
        $oView->tJoinItem = model_rightsManagerMulti::getInstance()->findSelectItem();

        $this->oLayout->add('main', $oView);
    }

    private function processEdit() {
        if (!_root::getRequest()->isPost()) { //si ce n'est pas une requete POST on ne soumet pas
            return null;
        }

        $oPluginXsrf = new plugin_xsrf();
        if (!$oPluginXsrf->checkToken(_root::getParam('token'))) { //on verifie que le token est valide
            return array('token' => $oPluginXsrf->getMessage());
        }


        $oRightsManagerMulti = model_rightsManagerMulti::getInstance()->findById(_root::getParam('id'));

        $sGroupText = trim(_root::getParam('groups_id_text'));
        $sActionText = trim(_root::getParam('actions_id_text'));
        $sItemText = trim(_root::getParam('items_id_text'));

        $tColumn = array('groups_id', 'actions_id', 'items_id');
        foreach ($tColumn as $sColumn) {
            $oRightsManagerMulti->$sColumn = _root::getParam($sColumn, null);
        }

        if ($oRightsManagerMulti->save()) {
            //une fois enregistre on redirige (vers la page liste)
            _root::redirect('rightsManagerMulti::index');
        } else {
            return $oRightsManagerMulti->getListError();
        }
    }

    public function _new() {

        $tMessage = $this->processNew();

        $oPermission = new row_rightsManagerMulti();
        $oView = new _view('rightsManagerMulti::new');
        $oView->oPermission = $oPermission;

        $oPluginXsrf = new plugin_xsrf();
        $oView->token = $oPluginXsrf->getToken();
        $oView->tMessage = $tMessage;

        $oView->tJoinGroup = model_rightsManagerMulti::getInstance()->findSelectGroup();
        $oView->tJoinAction = model_rightsManagerMulti::getInstance()->findSelectAction();
        $oView->tJoinItem = model_rightsManagerMulti::getInstance()->findSelectItem();

        $this->oLayout->add('main', $oView);
    }

    private function processNew() {
        if (!_root::getRequest()->isPost()) { //si ce n'est pas une requete POST on ne soumet pas
            return null;
        }

        $oPluginXsrf = new plugin_xsrf();
        if (!$oPluginXsrf->checkToken(_root::getParam('token'))) { //on verifie que le token est valide
            return array('token' => $oPluginXsrf->getMessage());
        }


        $oRightsManagerMulti = new row_rightsManagerMulti;

        $sGroupText = trim(_root::getParam('groups_id_text'));
        $sActionText = trim(_root::getParam('actions_id_text'));
        $sItemText = trim(_root::getParam('items_id_text'));

        $tColumn = array('groups_id', 'actions_id', 'items_id');
        foreach ($tColumn as $sColumn) {
            $oRightsManagerMulti->$sColumn = _root::getParam($sColumn, null);
        }

        if ($sGroupText != '') {
            $oGroup = model_rightsManagerMulti::getInstance()->findGroupByName($sGroupText);
            if (!$oGroup) {
                model_rightsManagerMulti::getInstance()->insertGroup($sGroupText);
                $oGroup = model_rightsManagerMulti::getInstance()->findGroupByName($sGroupText);
            }
            $oRightsManagerMulti->groups_id = $oGroup->id;
        }
        if ($sActionText != '') {
            $oAction = model_rightsManagerMulti::getInstance()->findActionByName($sActionText);
            if (!$oAction) {
                model_rightsManagerMulti::getInstance()->insertAction($sActionText);
                $oAction = model_rightsManagerMulti::getInstance()->findActionByName($sActionText);
            }
            $oRightsManagerMulti->actions_id = $oAction->id;
        }
        if ($sItemText != '') {
            $oItem = model_rightsManagerMulti::getInstance()->findItemByName($sItemText);
            if (!$oItem) {
                model_rightsManagerMulti::getInstance()->insertItem($sItemText);
                $oItem = model_rightsManagerMulti::getInstance()->findItemByName($sItemText);
            }
            $oRightsManagerMulti->items_id = $oItem->id;
        }

        if ($oRightsManagerMulti->save()) {
            //une fois enregistre on redirige (vers la page liste)
            _root::redirect('rightsManagerMulti::index');
        } else {
            return $oRightsManagerMulti->getListError();
        }
    }

    public function _delete() {

        $tMessage = $this->processDelete();

        $oPermission = model_rightsManagerMulti::getInstance()->findById(_root::getParam('id'));
        $oView = new _view('rightsManagerMulti::delete');
        $oView->oPermission = $oPermission;

        $oPluginXsrf = new plugin_xsrf();
        $oView->token = $oPluginXsrf->getToken();
        $oView->tMessage = $tMessage;

        $oView->tJoinGroup = model_rightsManagerMulti::getInstance()->findSelectGroup();
        $oView->tJoinAction = model_rightsManagerMulti::getInstance()->findSelectAction();
        $oView->tJoinItem = model_rightsManagerMulti::getInstance()->findSelectItem();

        $this->oLayout->add('main', $oView);
    }

    private function processDelete() {
        if (!_root::getRequest()->isPost()) { //si ce n'est pas une requete POST on ne soumet pas
            return null;
        }

        $oPluginXsrf = new plugin_xsrf();
        if (!$oPluginXsrf->checkToken(_root::getParam('token'))) { //on verifie que le token est valide
            return array('token' => $oPluginXsrf->getMessage());
        }


        $oRightsManagerMulti = model_rightsManagerMulti::getInstance()->findById(_root::getParam('id'));

        $oRightsManagerMulti->delete();
        _root::redirect('rightsManagerMulti::index');
    }

    public function _editUser() {
        $tMessage = $this->processEditUser();

        $oUser = model_rightsManagerMulti::getInstance()->findUserById(_root::getParam('id'));
        $oView = new _view('rightsManagerMulti::userEdit');
        $oView->oUser = $oUser;

        $oPluginXsrf = new plugin_xsrf();
        $oView->token = $oPluginXsrf->getToken();
        $oView->tMessage = $tMessage;
        $oView->tGroup = model_rightsManagerMulti::getInstance()->findListGroupByUser(_root::getParam('id'));

        $oView->tJoinGroup = model_rightsManagerMulti::getInstance()->findSelectGroup();

        $this->oLayout->add('main', $oView);
    }

    private function processEditUser() {
        if (!_root::getRequest()->isPost()) { //si ce n'est pas une requete POST on ne soumet pas
            return null;
        }

        $oPluginXsrf = new plugin_xsrf();
        if (!$oPluginXsrf->checkToken(_root::getParam('token'))) { //on verifie que le token est valide
            return array('token' => $oPluginXsrf->getMessage());
        }

        $user_id = _root::getParam('id');
        $tGroup = _root::getParam('groups_id');

        model_rightsManagerMulti::getInstance()->updateUserGroup($user_id, $tGroup);

        _root::redirect('rightsManagerMulti::index');
    }

    public function after() {
        $this->oLayout->show();
    }

}
