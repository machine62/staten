<?php
$indexactive = "";
$storyactive = "";
$graphactive = "";
$confactive = "";
$detailactive = "";

$active = "active";

$links = _root::getParamNav();

$indexactive = strpos($links, "::index") !== false ? $active : "";
$detailactive = strpos($links, "::detail") !== false ? $active : "";
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
                    <a class="nav-link <?php echo $indexactive; ?> " href="<?php echo _root::getLink($this->pagelink.'::index'); ?>">Scores</a>
                    <a class="nav-link <?php echo $detailactive; ?> " href="<?php echo _root::getLink($this->pagelink.'::detail'); ?>">Detail</a>
                    <a class="nav-link <?php echo $graphactive; ?> " href="<?php echo _root::getLink($this->pagelink.'::graph'); ?>">Graph</a>
                    <a class="nav-link <?php echo $storyactive; ?> " href="<?php echo _root::getLink($this->pagelink.'::story'); ?>">Histoire</a>
                    <a class="nav-link <?php echo $confactive; ?> " href="<?php echo _root::getLink($this->pagelink.'::conf'); ?>">Conf</a>
                </nav>

            </div>

        </div>

     
    </div>

</div>


<?php endif ; ?>
