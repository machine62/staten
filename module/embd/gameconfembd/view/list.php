
<div class="row">
    <div class="col-lg-6 offset-lg-3 col-xs-12 col-sm-10 offset-sm-1  col-md-8 offset-md-2 col-xl-4 offset-xl-4">
        <table class=" table   table-bordered tablestory table-light">
            <thead class="thead-dark text-center">
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
                    <td class="text-center">
                        <?php echo $this->conf->getSetForWinGame(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de jeu pour gagner set
                    </td><!-- comment -->    
                    <td class="text-center">
                        <?php echo $this->conf->getjeuForWinSet(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        No Ad
                    </td><!-- comment -->    
                    <td class="text-center">
                        <?php echo (int) $this->conf->getIsNoAd(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Avec tie breack
                    </td><!-- comment -->    
                    <td class="text-center">
                        <?php echo (int) $this->conf->isTiebreackEnable(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de pt tie breack
                    </td><!-- comment -->    
                    <td class="text-center">
                        <?php echo $this->conf->TiebreackNumber(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Avec super tie breack
                    </td><!-- comment -->    
                    <td class="text-center">
                        <?php echo (int) $this->conf->isSuperTiebreackEnable(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de point pour super tie
                    </td><!-- comment -->    
                    <td class="text-center">
                        <?php echo $this->conf->superTiebreackNumber(); ?>
                    </td>
                </tr>



            </tbody>
        </table>

    </div>
    <div class="clearfix"></div>
</div>