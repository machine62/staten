<div class="row">
    <div class="col-12  col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
<table class=" table table-bordered tablestory table-light">
    <thead class="thead-dark">
        <tr>
            <th>
                Joueur 1
            </th>
            <th>
                Set
            </th> 
            <th>

            </th> 
            <th>
                pt
            </th>
            <th>
                Pt
            </th> 
            <th>

            </th> 
            <th>
                Set
            </th>
            <th>
                Joueur 2
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($this->tgameCurentScore)) : ?>
            <?php foreach ($this->tgameCurentScore as $gameCurentScore) : ?>
                <?php
 
                $winj1class = "table-success";
                $winj2class = "table-danger";
                if ($gameCurentScore["winpt"] == "j2") {
                    $winj1class = "table-danger";
                    $winj2class = "table-success";
                }
                ?>

                <tr >
                    <td class="<?php echo $winj1class; ?>">
                        <?php echo $this->j1->nomComplet(); ?>
                    </td>
                    <td class="<?php echo $winj1class; ?>">
                        <?php echo implode("-", $gameCurentScore["j1"]["sets"]); ?>
                    </td> 
                    <td >
                        <?php if ($gameCurentScore["serveur"] == "j1"): ?>

                            🎾
                        <?php endif; ?>

                    </td> 

                    <td class="table-dark">
                        <?php echo $gameCurentScore["j1"]["pt"]; ?>
                    </td>
                    <td class="table-dark">
                        <?php echo $gameCurentScore["j2"]["pt"]; ?>
                    </td>
                    <td >
                        <?php if ($gameCurentScore["serveur"] == "j2"): ?>

                            🎾
                        <?php endif; ?>
                    </td> 
                    <td class="<?php echo $winj2class; ?>">
                        <?php echo implode("-", $gameCurentScore["j2"]["sets"]); ?>
                    </td>
                    <td class="<?php echo $winj2class; ?>">
                        <?php echo $this->j2->nomComplet(); ?>
                    </td>



                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
    </div>
    <div class="clearfix"></div></div>