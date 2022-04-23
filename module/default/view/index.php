<div class="row">
    <div class="col-6">
        <div clas="row">
            <div class="col text-center">
                <a class="btn btn-success lienAConfirmer" href="<?php echo _root::getLink('default::reset'); ?>" datamessage="Nouvelles partie -  Êtes-vous sûr ?" >
                    New Game
                </a>
                <a class="btn btn-success " href="<?php echo _root::getLink('default::story'); ?>" >
                    View story
                </a>
                <a class="btn btn-danger lienAConfirmer"  href="<?php echo _root::getLink('default::redo'); ?>" datamessage="Annuler dernier point -  Êtes-vous sûr ?" >
                    Annuler dernier point
                </a>


            </div><!-- comment -->   

        </div>
        <div clas="row">
            <table class="table table-bordered   text-center  tablescoreboard ">
                <tbody>
                    <tr>
                        <th class="table-primary  text-left">
                            <?php echo $this->game->joueur1()->nomComplet(); ?>   
                            <?php if ($this->game->joueur1() == $this->game->getCurrentServ()) : ?>
                                🎾 
                            <?php endif; ?>



                        </th>
                        <?php for ($index = 1; $index < 6; $index++) : ?>

                            <td>
                                <?php if (!is_null($this->game->getSetByNumber($index))) : ?>
                                    <?php echo $this->game->getSetByNumber($index)->getJeuxWin($this->game->joueur1()); ?>

                                <?php else : ?>
                                    <?php echo '0'; ?>
                                <?php endif; ?>

                            </td>
                        <?php endfor; ?>

                        <td class="table-secondary">
                            <?php
                            echo $this->game->getCurrentSet()->getJeuxWin($this->game->joueur1());
                            ?>
                        </td>
                        <td class="table-secondary">
                            <?php echo $this->game->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur1(); ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-primary  text-left">
                            <?php echo $this->game->joueur2()->nomComplet(); ?>
                            <?php if ($this->game->joueur2() == $this->game->getCurrentServ()) : ?>
                                🎾 
                            <?php endif; ?>


                        </th>
                        <?php for ($index = 1; $index < 6; $index++) : ?>

                            <td>
                                <?php if (!is_null($this->game->getSetByNumber($index))) : ?>
                                    <?php echo $this->game->getSetByNumber($index)->getJeuxWin($this->game->joueur2()); ?>

                                <?php else : ?>
                                    <?php echo '0'; ?>
                                <?php endif; ?>

                            </td>
                        <?php endfor; ?>
                        <td class="table-secondary">
                            <?php
                            echo $this->game->getCurrentSet()->getJeuxWin($this->game->joueur2());
                            ?>
                        </td>
                        <td class="table-secondary">
                            <?php
                            echo $this->game->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur2();
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>


            <div >
                todo
            </div>

        </div>



        <div class="row">
            <div class="col text-center">
                <a class="btn btn-primary btn-lg" href="<?php echo _root::getLink('default::addpointj1'); ?> ">
                    <?php echo $this->game->joueur1()->prenom(); ?>
                </a>
            </div>
            <div class="col text-center">
                <a class="btn btn-primary btn-lg" href="<?php echo _root::getLink('default::addpointj2'); ?> ">
                    <?php echo $this->game->joueur2()->prenom(); ?>
                </a>
            </div>
        </div>

    </div>

    <div class="col-6">
        <table class="table table-bordered table-sm  text-center table-condensed ">
            <thead>
                <tr>
                    <th>
                        Conf
                    </th>
                    <th>
                        Valeur
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Nombre set pour gagner partie 
                    </td><!-- comment -->    
                    <td>
                        <?php echo $this->game->getConfig()->getSetForWinGame(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de jeu pour gagner set
                    </td><!-- comment -->    
                    <td>
                        <?php echo $this->game->getConfig()->getjeuForWinSet(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        No Ad
                    </td><!-- comment -->    
                    <td>
                        <?php echo (int) $this->game->getConfig()->getIsNoAd(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Avec tie breack
                    </td><!-- comment -->    
                    <td>
                        <?php echo (int) $this->game->getConfig()->isTiebreackEnable(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de pt tie breack
                    </td><!-- comment -->    
                    <td>
                        <?php echo $this->game->getConfig()->TiebreackNumber(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Avec super tie breack
                    </td><!-- comment -->    
                    <td>
                        <?php echo (int) $this->game->getConfig()->isSuperTiebreackEnable(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de point pour super tie
                    </td><!-- comment -->    
                    <td>
                        <?php echo $this->game->getConfig()->superTiebreackNumber(); ?>
                    </td>
                </tr>



            </tbody>
        </table>





    </div> 


</div>
<!---
<div class="row">
    <table class="highchart" data-graph-container-before="1" data-graph-type="column"  style="display:none">
        <thead>
            <tr>                                  
                <th></th>
                <th data-graph-stack-group="1">John</th>
                <th data-graph-stack-group="1" data-graph-datalabels-color="blue">Jane</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Apples</td>
                <td>5</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Oranges</td>
                <td>3</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Pears</td>
                <td>4</td>
                <td>3</td>
            </tr>
        </tbody>
    </table>
</div>
-->



<div class="row">
    <pre>
        <?php print_r($this->game->fulljsonSerialize()); ?>
    </pre>
</div>
<div class="row">
    <pre>
        <?php print_r(json_decode(json_encode($this->game))); ?>
    </pre>
</div>
<div class="row">
    <pre>
        <?php print_r($this->game); ?>
    </pre>
</div>
