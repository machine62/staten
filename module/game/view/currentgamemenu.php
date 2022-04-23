<?php
$indexactive = "";
$storyactive = "";
$graphactive = "";
$confactive = "";

$active = "active";

$links = _root::getParamNav();

$indexactive = strpos($links, "::index") !== false ? $active : "";
$storyactive = strpos($links, "::story") !== false ? $active : "";
$graphactive = strpos($links, "::graph") !== false ? $active : "";
$confactive = strpos($links, "::conf") !== false ? $active : "";
?>



<?php if (!(strpos($links, "::newgame") !== false)) : ?>

<div class="footer fixed-bottom">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <nav class="nav nav-pills nav-justified  " >
                    <a class="nav-link <?php echo $indexactive; ?> " href="<?php echo _root::getLink('game::index'); ?>">Scores</a>
                    <a class="nav-link <?php echo $storyactive; ?> " href="<?php echo _root::getLink('game::story'); ?>">Histoire</a>
                    <a class="nav-link <?php echo $graphactive; ?> " href="<?php echo _root::getLink('game::graph'); ?>">Graph</a>
                    <a class="nav-link <?php echo $confactive; ?> " href="<?php echo _root::getLink('game::conf'); ?>">Conf</a>
                </nav>

            </div>

        </div>

     
    </div>

</div>


<?php endif ; ?>
