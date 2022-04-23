<div class="login-form">
    <form action="" method="POST"  class="form-signin" role="form">
        <h2 class="text-center">Authentification</h2>       
        <div class="form-group">
            <input class="form-control" placeholder="Nom d'utilisateur" type="text" name="login" autocomplete="off"/>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Mot de passe" type="password" name="password" autocomplete="off"/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </div>
    </form>
    <?php if ($this->sError != ''): ?>
        <p style="color:red"><?php echo $this->sError ?></p>
    <?php endif; ?>
    <p class="text-center"><a href="<?php echo _root::getLink('login::inscription') ?>">S'inscrire</a></p>
</div>
