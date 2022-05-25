


<div class="row formnewgame">

    <form action="" method="POST"  role="form" class="col-12">
        <!--j1 -->

        <div class="form-group">  
            <h4>Consultation</h4>

            <div class="form-group row">
                <label for="ticketview" class="col-sm-2 col-form-label">Lien a communiquer</label>
                <div class="col-sm-10">
                    <?php if (strlen($this->oGame->ticket) != 0) : ?>
                        <?php $txtlien = explode("index.php?:nav", 'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])[0] . _root::getLink('externalview::game', array("link" => $this->oGame->ticket)); ?>  
                    <?php else : ?>
                        <?php $txtlien = "Vous n'avez pas de lien consultable"; ?>


                    <?php endif; ?>
                    <textarea class="form-control" id="ticketview" rows="3"><?php echo $txtlien; ?></textarea>

                </div>
            </div>
        </div>  

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-info   " href="<?php echo $this->getLink('gamelist::show', array("gameid" => $this->oGame->gameid, "link" => "changelink")) ?>">Creer/Changer de lien</a>
                <a class="btn btn-danger   " href="<?php echo $this->getLink('gamelist::show', array("gameid" => $this->oGame->gameid, "link" => "dellink")) ?>">Supprimer le lien</a>
                <a class="btn btn-link" href="<?php echo $this->getLink('gamelist::list') ?>">Retour</a>
            </div>
        </div>

    </form>




</div>
