<form class="form-horizontal" action="" method="POST" >
	
	<div class="form-group">
		<label class="col-sm-2 control-label">gameid</label>
		<div class="col-sm-10"><?php echo $this->oGame->gameid ?></div>
	</div>
		
	<div class="form-group">
		<label class="col-sm-2 control-label">date</label>
		<div class="col-sm-10"><?php echo $this->oGame->date ?></div>
	</div>
		
	<div class="form-group">
		<label class="col-sm-2 control-label">accountid</label>
		<div class="col-sm-10"><?php echo $this->oGame->accountid ?></div>
	</div>
		
	<div class="form-group">
		<label class="col-sm-2 control-label">ticket</label>
		<div class="col-sm-10"><?php echo $this->oGame->ticket ?></div>
	</div>
		
	
	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
			 <a class="btn btn-default" href="<?php echo $this->getLink('gamelist::list')?>">Retour</a>
		</div>
	</div>
</form>
