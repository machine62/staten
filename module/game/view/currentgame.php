<?php 
$disableserv = $this->game->getCurrentSet()->getCurrentJeu()->getstateservend() ? "disabled" : "" ;




?>


<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <h4>
          Serveur : <?php echo $this->game->getCurrentServ()->nomComplet(); ?> <a class="float-right btn-link btn"      href="<?php echo _root::getLink('game::eventchangecurrentserv'); ?>">
                changer 
            </a>
        </h4>
         
        <div class="group-addservice row">
            <div class="col-4" >
                <a class="btn  btn-lg  btn-outline-success btn-addservice <?php echo $disableserv ; ?>"  href="<?php echo _root::getLink('game::eventservok');?>">
                  OK
                </a>
            </div>
            <div class="col-4" >
                <a class="btn btn-outline-danger btn-lg btn-addservice <?php echo $disableserv ; ?>" href="<?php echo _root::getLink('game::eventservfault'); ?>">
                    Faute
                </a>
            </div>
            <div class="col-4" >
                <a class="btn btn-outline-danger  btn-lg btn-addservice  <?php echo $disableserv ; ?>" href="<?php echo _root::getLink('game::eventfaultreturn'); ?>">
                     retour <br>faute
                </a>
            </div>
        </div>
        <div class="group-addservice row">
            <div class="col-4" >
                <a class="btn btn-outline-success btn-lg  btn-addservice  <?php echo $disableserv ; ?>" href="<?php echo _root::getLink('game::eventservace'); ?>">
                    Ace 
                </a> 
            </div>
            <div class="col-4" >

            </div>
            <div class="col-4" >
                <a class="btn btn-outline-success  btn-lg btn-addservice  <?php echo $disableserv ; ?>" href="<?php echo _root::getLink('game::eventwinreturn'); ?>">
                    retour <br>gagnant
                </a> 
            </div>

        </div>
        <p class="text-center"> Service <?php echo $this->game->getCurrentSet()->getCurrentJeu()->getstateservball();?>   
        </p>
        <hr>




    </div>

</div>



<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <h4>Echange</h4>
        <div class="group-addevent row">
            <div class="col-3" >

                <?php echo $this->game->joueur1()->nomComplet(); ?>

            </div>  
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-success btn-addevent" href="<?php echo _root::getLink('game::addpointj1'); ?> ">
                    Point
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="<?php echo _root::getLink('game::eventfaultnetj1'); ?>">
                    Faute<br>filet
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="<?php echo _root::getLink('game::eventfaultoutj1'); ?>">
                    Faute<br>dehors
                </a>

            </div>

        </div>
        <div class="group-addevent row">
            <div class="col-3" >

                <?php echo $this->game->joueur2()->nomComplet(); ?>

            </div>  
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-success btn-addevent" href="<?php echo _root::getLink('game::addpointj2'); ?> ">
                    Point
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="<?php echo _root::getLink('game::eventfaultnetj2'); ?>">
                    Faute<br>filet
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="<?php echo _root::getLink('game::eventfaultoutj2'); ?>">
                    Faute<br>dehors
                </a>

            </div>

        </div>
         <hr>
    </div>
   
</div>




<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
<!--
        <div class="group-addpoint row">



            <a class="btn btn-primary btn-lg col-5 disabled <?php echo $this->disabled; ?>" href="<?php echo _root::getLink('game::addpointj1'); ?> ">
                Point <br> <?php echo $this->game->joueur1()->prenom(); ?>
            </a>

            <div class="col">
            </div>

            <a class="btn btn-primary btn-lg  col-5 disabled <?php echo $this->disabled; ?>" href="<?php echo _root::getLink('game::addpointj2'); ?> ">
                Point <br> <?php echo $this->game->joueur2()->prenom(); ?>
            </a>

            <div class="clearfix"></div>

        </div>


        <br>
-->
        <div class="group-addpoint row">


            <a class="btn btn-danger btn-lg col-12 lienAConfirmer"  href="<?php echo _root::getLink('game::redo'); ?>" datamessage="Annuler dernier point -  Êtes-vous sûr ?" >
                Annuler dernier point
            </a>


            <div class="clearfix"></div>
        </div>

    </div>

</div>