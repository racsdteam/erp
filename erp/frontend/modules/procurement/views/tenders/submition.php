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
<h3>Click here To Submit the tender</h3>
<div class="d-flex  flex-sm-row flex-column  justify-content-between">
   
  <div class="float-right">
     <p>
        <?= Html::a('<i class="fas fa-file"></i> Submit The Tender', ['tenders/submition', 'id' =>(string) $model->_id,'number'=>$tender_number],
         [
          'class' => 'btn btn-outline-success btn-lg ','title'=>'Submit Tender',
          'data' => [
              'confirm' => 'Are you sure you want to Save this Tender?',
              'method' => 'post',
          ]
          ]) ?>
    </p>   
      </div>
  </div> 
</div>