<?php

use yii\helpers\Html;

if(empty($model->number))
$tender_number= $model->generateNumner();
else
$tender_number= $model->number;
?>
<?= $this->render('_tender_info', [
        'model' => $model,
    ]) ?>
<h3>Tender Stages Management</h3>

<div class="card card-default text-dark">
        
        <div class="card-header ">
             <h3 class="card-title"><i class="fas fa-database"></i>Tender Stages Management </h3>
        </div>
        <div class="card-body"> 
        <?php
if($model->isTenderInProgress()):
  ?>

<div class="card-footer">
<div class="row">
<div class="col-sm-3 col-6">
<div class="description-block border-right">
<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
<h5 class="description-header">$35,210.43</h5>
<span class="description-text">TOTAL REVENUE</span>
</div>

</div>

<div class="col-sm-3 col-6">
<div class="description-block border-right">
<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
<h5 class="description-header">$10,390.90</h5>
<span class="description-text">TOTAL COST</span>
</div>

</div>

<div class="col-sm-3 col-6">
<div class="description-block border-right">
<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
<h5 class="description-header">$24,813.53</h5>
<span class="description-text">TOTAL PROFIT</span>
</div>

</div>

<div class="col-sm-3 col-6">
<div class="description-block">
<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
<h5 class="description-header">1200</h5>
<span class="description-text">GOAL COMPLETIONS</span>
</div>

</div>
</div>

</div>
  <?php
  endif; 
  ?>
      </div>
  </div> 
</div>