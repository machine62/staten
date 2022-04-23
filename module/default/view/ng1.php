
<div class="row">
    <form action="" method="POST"  role="form">
        <div class="form-group">  
            <h2>Joueur 1</h2>
            <div class="col-xs-6">
                <input type="text" name="j1nickname" class="form-control" placeholder="Joueur 1" value="<?php echo $this->j1nickname; ?>">
            </div>
            <div class="col-xs-6">
                <input type="text" name="j1name" class="form-control" placeholder="Nom" value="<?php echo $this->j1name; ?>">
            </div>
        </div>  
        <div class="form-group">  
            <h2>Joueur 2</h2>
            <div class="col-xs-6">
                <input type="text" name="j2nickname" class="form-control" placeholder="Joueur 2" value="<?php echo $this->j2nickname; ?>">
            </div>
            <div class="col-xs-6">
                <input type="text" name="j2name" class="form-control" placeholder="Nom"  value="<?php echo $this->j2name; ?>">
            </div>
        </div>  
        <div class="form-group">  
            <h2>Format</h2>
            <label for="format" class="col-sm-4 control-label">format Du Match</label>
            <div class="col-sm-6">
                <select class="form-control form-select" id="format" name="format">
                    <option value="0">Format du match</option>
                    <option value="1">1 - 3 sets à 6 jeux</option>
                    <option value="2">2 - 2 sets à 6 jeux ; 3ème set = SJD à 10 points</option>
                    <option value="3">3 - 2 sets à 4 jeux ; pt décisif ; JD à 4/4 ; 3ème set = SJD à 10 pts</option>
                    <option value="4">4 - 2 sets à 6 jeux ; pt décisif ; 3ème set = SJD à 10 pts</option>
                    <option value="5">5 - 2 sets à 3 jeux ; pt décisif ; JD à 2/2 ; 3ème set = SJD à 10 pts</option>
                    <option value="6">6 - 2 sets à 4 jeux ; pt décisif ; JD à 3/3 ; 3ème set = SJD à 10 pts</option>
                    <option value="7">7 - 2 sets à 5 jeux ; pt décisif ; JD à 4/4 ; 3ème set = SJD à 10 pts</option>
                </select>
            </div>   
        </div>  
        <div class="form-group">  
            <h2>Service</h2>
            <label for="firstserv" class="col-sm-4 control-label">Premier srveur</label>
            <div class="col-sm-6">
                <select class="form-control" name="firstserv" id=""firstserv>
                    <option  selected="selected"  value="0">Premier serveur</option>
                    <option  value="1">Joueur 1</option>
                    <option  value="2">Joueur 2</option>

                </select>
            </div>   
        </div>  


        <button type="submit" class="btn btn-info btn-lg btn-outline-dark">Valider</button>
    </form>

    <?php echo $this->j2name; ?>


</div>

<!--


[setForWinGame:my_gameConfig:private] => 2
[jeuForWinSet:my_gameConfig:private] => 2
[noAd:my_gameConfig:private] => 
[isTiebreack:my_gameConfig:private] => 1
[TiebreackNumber:my_gameConfig:private] => 7
[isSuperTiebreack:my_gameConfig:private] => 1
[superTiebreackNumber:my_gameConfig:private] => 10

-->