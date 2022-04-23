<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
          <div class="container">
    <a class="navbar-brand">Stats tennis</a>
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto ">
            <?php foreach ($this->tLink as $sLibelle => $sLink): ?>
                <?php if (_root::getParamNav() == $sLink): ?>
                    <li class="nav-item active"><a class="nav-link" href="<?php echo $this->getLink($sLink) ?>"><?php echo $sLibelle ?></a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $this->getLink($sLink) ?>"><?php echo $sLibelle ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
                    <!--
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com/" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gauche</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>   
                    -->
        </ul>
        <ul class="navbar-nav">
              <?php foreach ($this->tLinkright as $sLibelle => $sLink): ?>
                <?php if (_root::getParamNav() == $sLink): ?>
                    <li class="nav-item active"><a class="nav-link" href="<?php echo $this->getLink($sLink) ?>"><?php echo $sLibelle ?></a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $this->getLink($sLink) ?>"><?php echo $sLibelle ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

     </div>
     </div>
</nav>


