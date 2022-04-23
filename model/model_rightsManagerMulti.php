<?php
class model_rightsManagerMulti extends abstract_model{
	
	protected $sClassRow='row_rightsManagerMulti';
	
	protected $sTable='permissions';
	protected $sConfig='pdoMysqlExple';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('
		SELECT 
			actions.name as actionName, 
			items.name as itemName,
			groups.name as groupName,
			permissions.id 

		FROM permissions
			INNER JOIN actions
				ON actions.id=permissions.actions_id
			INNER JOIN items
				ON items.id=permissions.items_id
			INNER JOIN groups
				ON groups.id=permissions.groups_id
		
			');
	}
	
	public function findListByUser($user_id){
		return $this->findManySimple('
		SELECT 
			actions.name as actionName, 
			items.name as itemName
		FROM permissions
			INNER JOIN groupsusers
				ON groupsusers.groups_id=permissions.groups_id
			INNER JOIN actions
				ON actions.id=permissions.actions_id
			INNER JOIN items
				ON items.id=permissions.items_id
		WHERE groupsusers.users_id=?
			',$user_id);
	}
	
	public function insertGroup($sName){
		$this->execute('INSERT INTO groups (name) VALUES(?)',$sName);
	}
	public function insertAction($sName){
		$this->execute('INSERT INTO actions (name) VALUES(?)',$sName);
	}
	public function insertItem($sName){
		$this->execute('INSERT INTO items (name) VALUES(?)',$sName);
	}
	
	public function findGroupByName($sName){
		return $this->findOneSimple('SELECT id as id FROM groups WHERE name=?',$sName);
	}
	public function findActionByName($sName){
		return $this->findOneSimple('SELECT id as id FROM actions WHERE name=?',$sName);
	}
	public function findItemByName($sName){
		return $this->findOneSimple('SELECT id as id FROM items WHERE name=?',$sName);
	}
	
	public function findSelectGroup(){
		$tItem=$this->findManySimple('SELECT id,name FROM groups');
		$tSelect=array();
		if($tItem){
			foreach($tItem as $oItem){
				$tSelect[ $oItem->id ]=$oItem->name;
			}
		}
		return $tSelect;
	}
	public function findSelectAction(){
		$tItem=$this->findManySimple('SELECT id,name FROM actions');
		$tSelect=array();
		if($tItem){
			foreach($tItem as $oItem){
				$tSelect[ $oItem->id ]=$oItem->name;
			}
		}
		return $tSelect;
	}
	public function findSelectItem(){
		$tItem=$this->findManySimple('SELECT id,name FROM items');
		$tSelect=array();
		if($tItem){
			foreach($tItem as $oItem){
				$tSelect[ $oItem->id ]=$oItem->name;
			}
		}
		return $tSelect;
	}
	
	public function findListUser(){
		return $this->findManySimple('SELECT id,name  FROM account');
	}
	public function findUserById($user_id){
		return $this->findOneSimple('SELECT id,name FROM account WHERE id=?',$user_id);
	}
	public function findListGroupByUser($user_id){
		$tRow=$this->findManySimple('SELECT groups_id FROM groupsusers WHERE users_id=?',$user_id);
		$tGroup=array();
		foreach($tRow as $oRow){
			$tGroup[$oRow->groups_id]=$oRow->groups_id;
		}
		return $tGroup;
	}
	public function updateUserGroup($user_id,$tGroup){
		$this->execute('DELETE FROM groupsusers WHERE users_id=?',array($user_id));
		if($tGroup){
			foreach($tGroup as $group_id){
				$this->execute('INSERT INTO groupsusers (groups_id,users_id) VALUES (?,?)',array($group_id,$user_id));
			}
		}
	}
	
	public function loadForUser($oUser){
		//on purge
		_root::getACL()->purge();
		
		$tPermission=$this->findListByUser($oUser->id);
		if($tPermission){
			foreach($tPermission as $oPermission){
				_root::getACL()->allow($oPermission->actionName,$oPermission->itemName);
			}
		}
	}
	
}
class row_rightsManagerMulti extends abstract_row{
	
	protected $sClassModel='model_rightsManagerMulti';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB','Le champ n\est pas &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isNotEqual('champ','valeurB','Le champ est &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isUpperThan('champ','valeurB','Le champ n\est pas sup&eacute; &agrave; '.$valeurB);
		$oPluginValid->isUpperOrEqualThan('champ','valeurB','Le champ n\est pas sup&eacute; ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isLowerThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur &agrave; '.$valeurB);
		$oPluginValid->isLowerOrEqualThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isEmpty('champ','Le champ n\'est pas vide');
		$oPluginValid->isNotEmpty('champ','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isEmailValid('champ','L\email est invalide');
		$oPluginValid->matchExpression('champ','/[0-9]/','Le champ n\'est pas au bon format');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/','Le champ ne doit pas &ecirc;tre a ce format');
		*/

		return $oPluginValid;
	}

	public function isValid(){
		return $this->getCheck()->isValid();
	}
	public function getListError(){
		return $this->getCheck()->getListError();
	}
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		return true;
	}

}
