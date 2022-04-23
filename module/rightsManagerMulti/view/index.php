<?php
/*
 examplemodule
 * 
 examplePermissionId

 exampleUser_login
 exampleUser_id
 exampleUser_groupsId
 * */
?>
<h2>Liste des permissions</h2>
<table class="table table-striped">
	<tr>
		<th>Groupe</th>
		<th>Action</th>
		<th>Element</th>
		<th></th>
	</tr>
	<?php if($this->tPermission):?>
		<?php foreach($this->tPermission as $oPermission):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			<td><?php echo $oPermission->groupName?></td>
			<td><?php echo $oPermission->actionName?></td>
			<td><?php echo $oPermission->itemName?></td>
			<td>
				
				<a href="<?php echo $this->getLink('rightsManagerMulti::edit',array(
										'id'=>$oPermission->id
									) 
							)?>">Modifier</a>
				|
				<a href="<?php echo $this->getLink('rightsManagerMulti::delete',array(
										'id'=>$oPermission->id
									) 
							)?>">Supprimer</a>
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="5">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>
<p><a class="btn btn-primary" href="<?php echo $this->getLink('rightsManagerMulti::new') ?>">New</a></p>

<h2>Liste des utilisateurs</h2>
<table class="table table-striped">
	<tr>
		<th>User</th>
		<th>Groupe</th>
		<th></th>
	</tr>
	<?php if($this->tUser):?>
		<?php foreach($this->tUser as $oUser):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			<td><?php echo $oUser->name?></td>
			<td><?php $tGroup=model_rightsManagerMulti::getInstance()->findListGroupByUser($oUser->id);
			$tGroupName=array();
			if($tGroup){
				foreach($tGroup as $grpId){
					if(isset($this->tJoinGroup[$grpId])){
						$tGroupName[]=$this->tJoinGroup[$grpId];
					}
				}
				echo implode(',',$tGroupName);
			}
			?></td>
			 <td><a href="<?php echo $this->getLink('rightsManagerMulti::editUser',array(
										'id'=>$oUser->id
									) 
							)?>">Modifier</a></td>
		</tr>
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="3">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>
