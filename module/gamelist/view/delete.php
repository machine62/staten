<?php
$oForm=new plugin_form();
if (isset($this->tMessage))
{
    $oForm->setMessage($this->tMessage);
}

?>



<div class="alert alert-danger" role="alert">
  <h3 class="alert-heading">Suppression</h3>
  <p>Attention, cette action est définitive.... </p><!-- comment --><hr>
  <form action="" method="POST" >

      <input class="btn btn-danger btn-lg" type="submit" value="Supprimer" /> 
      <a class="btn btn-link" href="#">Annuler</a>

      <?php echo $oForm->getToken('token', $this->token) ?>

  </form>

</div>