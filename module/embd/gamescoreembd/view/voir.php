<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 ">
        <table class="table table-condensed   text-center  tablescoreboard table-light">
            <tbody>
                <tr>
                    <!--<td class="table-secondary">
                    <?php
                    echo $this->game->getCurrentSet()->getJeuxWin($this->game->joueur1());
                    ?>
                    </td>-->
                    <td class="tablestory-serv">
                        <?php if ($this->game->joueur1() == $this->game->getCurrentServ()) : ?>
                            🎾 
                        <?php endif; ?>
                    </td>
                    <td class="table-secondary tablestory-point">
                        <?php echo $this->game->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur1(); ?>

                    </td>


                    <th class="table-primary  tablestory-player">
                        <?php echo $this->game->joueur1()->nomComplet(); ?>   
                       



                    </th>
                    <?php //for ($index = 1; $index < 6; $index++) : // quand il sera grand .. ?>

                    <?php for ($index = 1; $index < 4; $index++) : ?>

                        <td class="tablestory-point-<?php echo $index; ?>">
                            <?php if (!is_null($this->game->getSetByNumber($index))) : ?>
                                <?php echo $this->game->getSetByNumber($index)->getJeuxWin($this->game->joueur1()); ?>

                            <?php else : ?>
                                <?php echo '-'; ?>
                            <?php endif; ?>

                        </td>
                    <?php endfor; ?>


                </tr>
                <tr> <!--
                    <td class="table-secondary">
                    <?php
                    echo $this->game->getCurrentSet()->getJeuxWin($this->game->joueur2());
                    ?>
                    </td>-->
                    <td class="tablestory-serv">
                        <?php if ($this->game->joueur2() == $this->game->getCurrentServ()) : ?>
                            🎾 
                        <?php endif; ?>
                    </td>
                    <td class="table-secondary tablestory-point">
                        <?php
                        echo $this->game->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur2();
                        ?>

                    </td>

                    <th class="table-primary tablestory-player ">
                        <?php echo $this->game->joueur2()->nomComplet(); ?>



                    </th>
                    <?php //for ($index = 1; $index < 6; $index++) : // quand il sera grand .. ?>

                    <?php for ($index = 1; $index < 4; $index++) : ?>

                        <td class="tablestory-point-<?php echo $index; ?>">
                            <?php if (!is_null($this->game->getSetByNumber($index))) : ?>
                                <?php echo $this->game->getSetByNumber($index)->getJeuxWin($this->game->joueur2()); ?>

                            <?php else : ?>
                                <?php echo '-'; ?>
                            <?php endif; ?>

                        </td>
                    <?php endfor; ?>

                </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
</div>
