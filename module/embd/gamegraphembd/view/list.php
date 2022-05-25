

<br><!-- comment -->
<nav class="nav nav-tabs">
    <a class="nav-item nav-link active" href="#p1" data-toggle="tab">Points</a>
    <a class="nav-item nav-link" href="#p2" data-toggle="tab">Points répartition</a>
    <a class="nav-item nav-link" href="#p3" data-toggle="tab">Joueur 1</a>
    <a class="nav-item nav-link" href="#p4" data-toggle="tab">Joueur 2</a>
</nav>


<!--<div class="tab-content col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">-->
<div class="tab-content">
    <div class="tab-pane active" id="p1">
        <?php foreach ($this->graphptss as $graph): ?>
            <?php echo $graph->show(); ?>
        <?php endforeach; ?>

    </div>
    <div class="tab-pane" id="p2">
        <?php foreach ($this->graphdetails as $graph): ?>
            <?php echo $graph->show(); ?>
        <?php endforeach; ?>

    </div>
    <div class="tab-pane  " id="p3">
       <?php foreach ($this->graphJoueur1 as $graph): ?>
            <?php echo $graph->show(); ?>
        <?php endforeach; ?>


    </div>
    
     <div class="tab-pane  " id="p4">
       <?php foreach ($this->graphJoueur2 as $graph): ?>
            <?php echo $graph->show(); ?>
        <?php endforeach; ?>

    </div>
</div>


