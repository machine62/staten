
<h2>liste des parties</h2>

<table class="table text-center  table-bordered table-striped table-responsive-sm table-gamelist">
    <thead class="table-dark">
        <tr >
            <th></th>
            <th>date</th>

            <th>player</th>

            <th>Score</th>

            <th class=" d-none d-sm-table-cell " >accountid</th>

            <th class="d-none d-sm-table-cell" >ticket</th>

            <th>Actions</th>

            <th class=" d-none d-sm-table-cell " >fini</th>
        </tr> 

    </thead>
    <tbody class="table-light">
        <?php if ($this->tGame): ?>
            <?php foreach ($this->tGame as $oGame): ?>
                <?php
                //contextuel table class
                $j1htmlclasscase = "table-secondary";
                $j2htmlclasscase = "table-secondary";
                if ($this->oGamefile[$oGame->gameid]->isEnd() == $this->oGamefile[$oGame->gameid]->joueur1()->id()) {
                    $j1htmlclasscase = "table-success";
                    $j2htmlclasscase = "table-danger";
                }
                if ($this->oGamefile[$oGame->gameid]->isEnd() == $this->oGamefile[$oGame->gameid]->joueur2()->id()) {
                    $j1htmlclasscase = "table-danger";
                    $j2htmlclasscase = "table-success";
                }
                ?>



                <tr>
                    <td  rowspan="2" class="align-middle"> 
                        <?php if (isset($_SESSION['game'])): ?>
                            <?php if ($oGame->gameid == $_SESSION['game']->id()) : ?>
                                👀
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td rowspan="2" class="align-middle"  > <?php echo date('m/d/Y', $oGame->date) ?><br><?php echo date('H:i:s', $oGame->date) ?></td>

                    <td class= "<?php echo $j1htmlclasscase; ?>">
                        <?php echo $this->oGamefile[$oGame->gameid]->joueur1()->nomComplet(); ?>
                    </td>


                     <td class= "<?php echo $j1htmlclasscase; ?>">
                        <?php echo implode(" - ", $this->oGamefile[$oGame->gameid]->getCurrentScore()["j1"]["sets"]) ?>
                    </td>
                    <td rowspan="2" class="align-middle d-none d-sm-table-cell "  >
                        <?php if (isset($this->tJoinaccount[$oGame->accountid])) : ?>
                            <?php echo $this->tJoinaccount[$oGame->accountid] ?>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td rowspan="2" class="align-middle  d-none d-sm-table-cell"  > <?php echo $oGame->ticket ?></td>

                    <td rowspan="2" class="align-middle"  > 
                        <a class="btn btn-light "  href="<?php echo _root::getLink('gamelist::changecurrentgame', array('gameid' => $oGame->gameid)); ?>"> 👀 </a>
                        <a class="btn btn-light lienAConfirmer" datamessage="Non implémenté" href=""> 🎟 </a>
                        <a class="btn btn-warning lienAConfirmer" datamessage="Attention, suppression définitive"  href="<?php echo _root::getLink('gamelist::delete', array('gameid' => $oGame->gameid)); ?>"> 🗑 </a>
                    </td>
                    <td rowspan="2" class="align-middle d-none d-sm-table-cell"  > 
                        <?php if ($this->oGamefile[$oGame->gameid]->isEnd()) : ?>
                            🏆
                        <?php endif; ?>
                      </td>
                </tr>
                <!--<td> <?php echo date('m/d/Y H:i:s', $oGame->date) ?></td>-->

            <td class= "<?php echo $j2htmlclasscase; ?>">
                <?php echo $this->oGamefile[$oGame->gameid]->joueur2()->nomComplet(); ?>
            </td>
            <td class= "<?php echo $j2htmlclasscase; ?>">
                <?php echo implode(" - ", $this->oGamefile[$oGame->gameid]->getCurrentScore()["j2"]["sets"]) ?>
            </td>



            <tr>
            </tr>	

        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">Aucune partie disponible</td>
        </tr>
    <?php endif; ?>


</tbody>

</table>

