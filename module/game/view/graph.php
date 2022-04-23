<nav class="nav nav-tabs">
    <a class="nav-item nav-link active" href="#p1" data-toggle="tab">Onglet 1</a>
    <a class="nav-item nav-link" href="#p2" data-toggle="tab">Onglet 2</a>
</nav>
<div class="tab-content">
    <div class="tab-pane active" id="p1">Panneau 1</div>
    <div class="tab-pane" id="p2">Panneau 2</div>
</div>

<?php
$getReadableStoryScore = $this->getReadableStoryScore;

$graphs = array();
foreach ($getReadableStoryScore as $StoryScore) {
    $title = "Points Par set";
    $thead = array("",);
    $serie = array();
}





foreach ($getReadableStoryScore as $StoryScore) {
//preparation data
    $dataGlobalscore["total"] = isset($dataGlobalscore["total"]) ? $dataGlobalscore["total"] : array();
    $dataGlobalscore["total"]["j1"] = isset($dataGlobalscore["total"]["j1"]) ? $dataGlobalscore["total"]["j1"] : 0;
    $dataGlobalscore["total"]["j2"] = isset($dataGlobalscore["total"]["j2"]) ? $dataGlobalscore["total"]["j2"] : 0;
    if (!isset($dataGlobalscore["byset"][$StoryScore["numberset"]])) {
        $dataGlobalscore["byset"][$StoryScore["numberset"]] = array();
        $dataGlobalscore["byset"][$StoryScore["numberset"]]["j1"] = 0;
        $dataGlobalscore["byset"][$StoryScore["numberset"]]["j2"] = 0;
    }
// fin prepa


    if ($StoryScore["winpt"] == "j1") {
        $dataGlobalscore["total"]["j1"] = $dataGlobalscore["total"]["j1"] + 1;
        $dataGlobalscore["byset"][$StoryScore["numberset"]]["j1"] = $dataGlobalscore["byset"][$StoryScore["numberset"]]["j1"] + 1;
    } else {
        $dataGlobalscore["total"]["j2"] = $dataGlobalscore["total"]["j2"] + 1;
        $dataGlobalscore["byset"][$StoryScore["numberset"]]["j2"] = $dataGlobalscore["byset"][$StoryScore["numberset"]]["j2"] + 1;
    }
}
?>
<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <table class="highchart" data-graph-container-before="1" data-graph-type="column"  style="display:none" data-graph-color-1="#A47D7C" data-graph-color-2="#dd7D7C" >
            <caption>Points Par set</caption>
            <thead>
                <tr>                                  
                    <th>fff</th>
                    <th data-graph-stack-group="1">j1</th>
                    <th data-graph-stack-group="1" data-graph-datalabels-color="pink">j2</th>
                    <th data-graph-stack-group="2" >autre</th>
                </tr>
            </thead>
            <tbody>
                <!--
                <tr>
                    <td>total</td>
                    <td><?php echo $dataGlobalscore["total"]["j1"]; ?></td>
                    <td><?php echo $dataGlobalscore["total"]["j2"]; ?></td>
                </tr>
                -->
<?php foreach ($dataGlobalscore["byset"]as $set => $value) : ?>

                    <tr>
                        <td>Set <?php echo $set; ?> </td>
                        <td><?php echo $value["j1"]; ?></td>
                        <td><?php echo $value["j2"]; ?></td>
                        <td><?php echo (int) ($value["j1"] + $value["j2"]); ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>







<!--


<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <table class="highchart" data-graph-container-before="1" data-graph-type="pie"  style="display:none">
            <caption>Titre</caption>
            <thead>
                <tr>                                  

                    <th>Joueur</th>
                    <th>pointgaganant</th>
                </tr>

            <tbody>
                <tr>
                    <td>j1</td>
                    <td>54</td>

                </tr>
                <tr>
                    <td>j2</td>
                    <td>60</td>

                </tr>

            </tbody>
        </table>
    </div>
</div>








<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <table class="highchart" data-graph-container-before="1" data-graph-type="column"  style="display:none">
            <caption>Titre</caption>
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
</div>


<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">


        <table class="highchart" data-graph-container="#graphcontainer2" data-graph-type="line" style="display:none" >
            <thead>
                <tr>                                  
                    <th>Month</th>
                    <th>Sales</th>
                    <th>Sales2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>January</td>
                    <td>8000</td>
                    <td>6000</td>
                </tr>
                <tr>
                    <td>February</td>
                    <td>12000</td>
                    <td>13000</td>
                </tr>
                <tr>
                    <td>March</td>
                    <td>18000</td>
                    <td>17000</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <div id="graphcontainer2">
        </div>
    </div>
</div>


-->