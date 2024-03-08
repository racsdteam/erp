<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\procurement\models\ProcurementDateTypes;

$this->title=$model->name;


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */


?>

 
<?php
    
    $dates=ProcurementDateTypes::find()->all();
   //$approval_request=PayrollApprovalRequests::findOneContainsPayroll($model->id); 
   $i=0;
   
   
      ?>
   
   
   <div class="invoice p-3 mb-3">
                   <div class="table-responsive">
    <table   class="tbl-report"  cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
       <tr> <th class="table-title" colspan="<?php echo 5+count($dates) ?>"><h1><?php echo $model->name; ?></h1>  </th></tr>
        <tr>
         
          <th  class="rotate"><div><div class="textH">S/N</div> </div></th>
            <th  class="rotate"><div><div class="textH">Title of Tenders</div> </div></th>
             <th class="rotate"><div><div class="textH">Estimated  cost (Frw)</div> </div></th>
         <th class="rotate"><div><div class="textH">Source of Funds</div> </div></th>
          <th class="rotate"><div><div class="textH">Tendering Method</div> </div></th>
         <?php foreach($dates as $index => $dateType)  : ?>
         
         <th class="rotate">
             <div><div class="textH"><?php echo $dateType->name ?></div> </div></th>
       
          <?php endforeach;?>
      </tr>
   </thead>
<tbody>
<?php foreach($model->activities as $activity): $i++;?>
<tr style="padding:5px ">
<td class="data-cell" style="padding: 5px"><?= $i ?></td>
<td class="data-cell desc-cell"  style="padding: 5px;";><?=$activity->description?></td>
<td class="data-cell"  style="padding: 5px; white-space: nowrap;"><?=$activity->estimate_cost ?></td>
<td class="data-cell"  style="padding: 5px; white-space: nowrap;"><?=$activity->fundingSource->name ?></td>
<td class="data-cell"  style="padding: 5px; white-space: nowrap;"><?=$activity->procurementMethod->code ?></td>
<?php  
$dates=[];
foreach($activity->procurementActivityDates as $date){
       
       $dates[$date->dateType->code]=$date;
   }

foreach(ProcurementDateTypes::find()->all() as $index => $dateType)  : ?>
    
<td class="data-cell"  style="padding: 5px"><?=$dates[$dateType->code]->planned_date?></td>
   
<?php endforeach;?>
</tr>
<?php endforeach ?>
    
                    </tbody>
            
                 
</table>



<div class="plan-caption">
<b>KEY:</b>
<p><b>ICB:</b> International competitive bidding. 
<b>NCB:</b> National Competitive Bidding. <b>RT:</b> Restricted Tendering. <b>SS:</b> Single Source. <b>RFQ:</b> Request for Quotations. <b>QCB:</b> Quality and Cost Based Selections</p>
     
   <div style='float: left;width:50%;text-align:left'>
   <b>Prepared by:</b><br/><br/>
   <?php
   
   echo $model->user0->first_name.' '.$model->user0->last_name;
   echo '<br/>';
   echo $model->user0->findPosition()->position;
   ?>
   
   </div>
   
    <div style="float:right;width:50%;text-align:right">
   <b>Approved by:</b><br/><br/>
   <?php
   
   echo $model->user0->first_name.' '.$model->user0->last_name;
   echo '<br/>';
   echo $model->user0->findPosition()->position;
   ?>
   
   </div>
</div>

</div>


 </div>
  





