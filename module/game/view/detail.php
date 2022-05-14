<?php
$fnRecherche1 = "getallj1";
$fnRecherche2 = "getallj2";
$fntime = "getTimeAll";


$maxSet = $this->plug->getNumberSet();



$vue = array();
$vue[0] = array("fnRecherche1" => "getallj1", "fnRecherche2" => "getallj2", "fnTime" => "getTimeAll");
$vue[1] = array("fnRecherche1" => "getj1set1", "fnRecherche2" => "getj2set1", "fnTime" => "getTimeSet1");
$vue[2] = array("fnRecherche1" => "getj1set2", "fnRecherche2" => "getj2set2", "fnTime" => "getTimeSet2");
$vue[3] = array("fnRecherche1" => "getj1set3", "fnRecherche2" => "getj2set3", "fnTime" => "getTimeSet3");
$vue[4] = array("fnRecherche1" => "getj1set4", "fnRecherche2" => "getj2set4", "fnTime" => "getTimeSet4");
$vue[5] = array("fnRecherche1" => "getj1set5", "fnRecherche2" => "getj2set5", "fnTime" => "getTimeSet5");
?>

<nav class="nav nav-tabs nav-pills">
    <a class="nav-item nav-link active" href="#p0" data-toggle="tab">Match</a>
    <?php for ($curNumSet = 1; $curNumSet < $maxSet + 1; $curNumSet++) : ?>
        <a class="nav-item nav-link" href="#p<?php echo $curNumSet; ?>" data-toggle="tab">Set <?php echo $curNumSet; ?> </a>

    <?php endfor; ?>
</nav>
<div class="tab-content">

    <?php for ($curNumSet = 0; $curNumSet < $maxSet + 1; $curNumSet++) : ?>
<?php
        $fnRecherche1 = $vue[$curNumSet]["fnRecherche1"];
        $fnRecherche2 = $vue[$curNumSet]["fnRecherche2"];
        $fntime =  $vue[$curNumSet]["fnTime"];

?>


        <?php if ($curNumSet == 0) : ?>
            <div class="tab-pane active" id="p<?php echo $curNumSet; ?>">

            <?php else : ?>
                <div class="tab-pane " id="p<?php echo $curNumSet; ?>">
                <?php endif; ?>


                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-xs-12 col-sm-12 col-md-10 offset-md-1 col-xl-6 offset-xl-3">
                        <table class=" table   table-bordered tablestory table-light table-striped">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th colspan="3">
                                        <?php if ($curNumSet == 0) : ?>
                                        Détail Match 
                                        <?php else : ?>
                                        Détail Set <?php echo $curNumSet; ?>
                                        <?php endif; ?>
                                        
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Durée 
                                    </td><!-- comment -->    
                                    <td colspan="2" class="text-center">
                                        <?php echo gmdate("H:i:s", (int)$this->plug->$fntime());
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                            <thead class="thead-dark text-center">
                                <tr class="table-dark">

                                    <th>
                                        Points
                                    </th>
                                    <th>
                                        Joueur 1
                                    </th>
                                    <th>
                                        Joueur 2
                                    </th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Points Gagnés
                                    </td><!-- comment -->    
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::POINTSCORE)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::POINTSCORE)); ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        Coups gagnants
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::POINT)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::POINT)); ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        Fautes directes
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::FAULTNET, my_story::FAULTOUT)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::FAULTNET, my_story::FAULTOUT)); ?>
                                    </td>

                                </tr>
                            </tbody>
                            <thead class="thead-dark text-center">
                                <tr class="table-dark">

                                    <th>
                                        Service
                                    </th>
                                    <th>
                                        Joueur 1
                                    </th>
                                    <th>
                                        Joueur 2
                                    </th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        1ere balle
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::SERVOK1, my_story::SERVACE1)); ?> / 
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::SERVOK1, my_story::SERVACE1, my_story::SERVFAULEB1)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::SERVOK1, my_story::SERVOK1)); ?> /<!-- comment -->
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::SERVOK1, my_story::SERVACE1, my_story::SERVFAULEB1)); ?>

                                    </td>


                                </tr>
                                <tr>
                                    <td>
                                        2eme balle
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::SERVOK2, my_story::SERVACE2)); ?> / 
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::SERVOK2, my_story::SERVACE2, my_story::SERVFAULEB2)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::SERVOK2, my_story::SERVACE2)); ?> /<!-- comment -->
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::SERVOK1, my_story::SERVACE2, my_story::SERVFAULEB2)); ?>

                                    </td>


                                </tr>
                                <tr>
                                    <td>
                                        Ace
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::SERVACE1, my_story::SERVACE2)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::SERVACE1, my_story::SERVACE2)); ?>
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        Double fautes
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::SERVFAULEB2)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::SERVFAULEB2)); ?>
                                    </td>


                                </tr>
                            </tbody>
                            <thead class="thead-dark text-center">
                                <tr class="table-dark">

                                    <th>
                                        Autres
                                    </th>
                                    <th>
                                        Joueur 1
                                    </th>
                                    <th>
                                        Joueur 2
                                    </th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Balle de break Marquée
                                    </td>
                                     <td class="text-center">

                                     <td class="text-center">
                                    <td>

                                    </td>


                                </tr>
                                <tr>
                                    <td>
                                        Points gagnés sur 1eme balle
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::POINTONFIRSTSERV)); ?> / <?php echo $this->plug->$fnRecherche1(array(my_story::POINTONFIRSTSERV, my_story::POINTLOOSEONFIRSTSERV)); ?>
                                    </td>
                                     <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::POINTONFIRSTSERV)); ?> / <?php echo $this->plug->$fnRecherche2(array(my_story::POINTONFIRSTSERV, my_story::POINTLOOSEONFIRSTSERV)); ?>
                                    </td>

                                </tr>


                                <tr>
                                    <td>
                                        Points gagnés sur 2eme balle
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche1(array(my_story::POINTONSECONDSERV)); ?> / <?php echo $this->plug->$fnRecherche1(array(my_story::POINTONSECONDSERV, my_story::POINTLOOSEONSECONDSERV)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $this->plug->$fnRecherche2(array(my_story::POINTONSECONDSERV)); ?> /<?php echo $this->plug->$fnRecherche2(array(my_story::POINTONSECONDSERV, my_story::POINTLOOSEONSECONDSERV)); ?>
                                    </td>

                                </tr>

                            </tbody>
                        </table>

                    </div>
                    <div class="clearfix"></div>
                </div>



            </div>

        <?php endfor; ?>





        <div class="tab-pane" id="p2">retest 2</div>
    </div>