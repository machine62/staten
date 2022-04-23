<?php 
$disableserv = $this->game->getCurrentSet()->getCurrentJeu()->getstateservend() ? "disabled" : "" ;




?>


<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <h4>
            service <?php echo $this->game->getCurrentSet()->getCurrentJeu()->getstateserv();?>  : <?php echo $this->game->getCurrentServ()->nomComplet(); ?> 
            <a class="float-right btn-link btn"      href="<?php echo _root::getLink('game::eventchangecurrentserv'); ?>">
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
                <a class="btn btn-outline-danger  btn-lg btn-addservice  <?php echo $disableserv ; ?>" href="#">
                     retour <br>faute
                </a>
            </div>
        </div>
        <div class="group-addservice row">
            <div class="col-4" >
                <a class="btn btn-outline-success btn-lg  btn-addservice  <?php echo $disableserv ; ?>" href="#">
                    Ace 
                </a> 
            </div>
            <div class="col-4" >

            </div>
            <div class="col-4" >
                <a class="btn btn-outline-success  btn-lg btn-addservice  <?php echo $disableserv ; ?>" href="#">
                    retour <br>gagnant
                </a> 
            </div>

        </div>

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
                <a class="btn  btn-lg  btn-outline-success btn-addevent" href="#">
                    Point
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="#">
                    Faute<br>filet
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="#">
                    Faute<br>dehors
                </a>

            </div>

        </div>
        <div class="group-addevent row">
            <div class="col-3" >

                <?php echo $this->game->joueur2()->nomComplet(); ?>

            </div>  
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-success btn-addevent" href="#">
                    Point
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="#">
                    Faute<br>filet
                </a>

            </div>
            <div class="col-3" >
                <a class="btn  btn-lg  btn-outline-danger btn-addevent" href="#">
                    Faute<br>dehors
                </a>

            </div>

        </div>
    </div>

</div>

<hr>
<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">

        <div class="group-addpoint row">



            <a class="btn btn-primary btn-lg col-5 <?php echo $this->disabled; ?>" href="<?php echo _root::getLink('game::addpointj1'); ?> ">
                Point <br> <?php echo $this->game->joueur1()->prenom(); ?>
            </a>

            <div class="col">
            </div>

            <a class="btn btn-primary btn-lg  col-5 <?php echo $this->disabled; ?>" href="<?php echo _root::getLink('game::addpointj2'); ?> ">
                Point <br> <?php echo $this->game->joueur2()->prenom(); ?>
            </a>

            <div class="clearfix"></div>

        </div>


        <br>

        <div class="group-addpoint row">


            <a class="btn btn-danger btn-lg col-12 lienAConfirmer"  href="<?php echo _root::getLink('game::redo'); ?>" datamessage="Annuler dernier point -  Êtes-vous sûr ?" >
                Annuler dernier point
            </a>


            <div class="clearfix"></div>
        </div>

    </div>

</div>