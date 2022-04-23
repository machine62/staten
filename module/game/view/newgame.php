
<?php if (isset($_SESSION['game'])) : ?>
    <div class="alert alert-warning" role="alert">
        <h3>Une partie est en cours</h3>
        <hr>
        <p>
            Vous risquez de perdre votre avancement.      
        </p>
    </div>
<?php endif; ?>

<div class="row formnewgame">
    
    <form action="" method="POST"  role="form" class="col-12">
        <!--j1 -->
        <div class="form-group">  
            <h4>Joueur 1</h4>
            <div class="form-group row">
                <label for="j1nickname" class="col-sm-2 col-form-label">Prenom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="j1nickname" name="j1nickname"  value="<?php echo $this->game->joueur1()->prenom(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="j1name" class="col-sm-2 col-form-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="j1name" name="j1name"  value="<?php echo $this->game->joueur1()->nom(); ?>">
                </div>
            </div>
        </div>  
        <!--j2 -->
        <div class="form-group">  
            <h4>Joueur 2</h4>
            <div class="form-group row">
                <label for="j2nickname" class="col-sm-2 col-form-label">Prenom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="j2nickname" name="j2nickname"  value="<?php echo $this->game->joueur2()->prenom(); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="j2name" class="col-sm-2 col-form-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="j2name" name="j2name"  value="<?php echo $this->game->joueur2()->nom(); ?>">
                </div>
            </div>
        </div>  

        <!--Conf -->
        <div class="form-group">  
            <h4>Configuration</h4>
            <div class="form-group row">
                <label for="format" class="col-sm-4 col-form-label">format Du Match</label>
                <div class="col-sm-8">
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
            <div class="form-group row">
                <label for="firstserv" class="col-sm-4 col-form-label">Premier serveur</label>
                <div class="col-sm-8">
                    <select class="form-control" name="firstserv" id=firstserv">
                        <option  selected="selected"  value="0">Premier serveur</option>
                        <option  value="1">Joueur 1</option>
                        <option  value="2">Joueur 2</option>

                    </select>

                </div>
            </div>
        </div>  




        <button type="submit" class="btn btn-info btn-lg ">Valider</button>
    </form>




</div>
