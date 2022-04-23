<?php 
/*
 examplemodule
 * 
 exampleGroupId
 exampleActionId
 exampleItemId
 * */

$oForm=new plugin_form($this->oPermission);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >

<table class="table table-striped">
	
	<tr>
		<th>Groupe</th>
		<th>Action</th>
		<th>Element</th>
	</tr>
	
	<tr>
		<td>
			<?php if(isset($this->tJoinGroup) and isset($this->tJoinGroup[$this->oPermission->groups_id])): echo $this->tJoinGroup[$this->oPermission->groups_id]; endif; ?>
		</td>
		
		<td>
			<?php if(isset($this->tJoinAction) and isset($this->tJoinAction[$this->oPermission->actions_id])): echo $this->tJoinAction[$this->oPermission->actions_id]; endif; ?>
		</td>
		
		<td>
			<?php if(isset($this->tJoinItem) and isset($this->tJoinItem[$this->oPermission->items_id])): echo $this->tJoinItem[$this->oPermission->items_id]; endif; ?>
		</td>
	</tr>

</table>

<p>
	Confirmez-vous la suppression ? <input class="btn btn-success" type="submit" value="Oui" /> <a class="btn btn-danger" href="<?php echo $this->getLink('rightsManagerMulti::list')?>">Non</a>
</p>

<?php echo $oForm->getToken('token',$this->token)?>

</form>
