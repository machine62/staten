
<div class="row">
  <div class="col-12  col-md-10 offset-md-1 col-lg-10 offset-lg-1 col-xl-10 offset-xl-1">
        <table class="highchart" 
               data-graph-container-before="1" 
               data-graph-type="<?php echo $this->graphType; ?>" 
               <?php foreach ($this->datagraphcolor as $key => $value) : ?> 
                   data-graph-color-<?php echo $key + 1; ?>="<?php echo $value; ?>" 
               <?php endforeach; ?>
               <?php if (!$this->tablevisible): ?>
                   style="display:none" 
               <?php endif; ?>
               >
            <caption>
                <?php echo $this->title; ?>
            </caption>
            <thead>
                <tr>         
                    <?php foreach ($this->datagraphhead as $key => $thead): ?> 
                        <?php if (isset($this->datagraphheadstack[$key])) : ?>
                            <th  data-graph-stack-group="<?php echo $this->datagraphheadstack[$key]; ?>">
                                <?php echo $thead; ?>
                            </th>
                        <?php else : ?>
                            <th >
                                <?php echo $thead; ?>
                            </th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <tbody>
                <?php foreach ($this->series as $serie): ?> 
                    <tr>
                        <?php foreach ($serie as $elem) : ?>
                            <td>
                                <?php echo $elem; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
           <!-- <tr>
                <td>j1</td>
                <td>54</td>
                <td>60</td>

            </tr>
            <tr>
                <td>j2</td>
                <td>60</td>
                <td>24</td>

            </tr>
                -->
            </tbody>
        </table>
    </div>
</div>


<br>

<hr>
<br><br>