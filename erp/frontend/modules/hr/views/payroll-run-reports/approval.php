<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\Employees;
use yii\bootstrap\ActiveForm;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\PayrollApprovalRequests;



/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */


?>
<?php
      $rows=$model->payrollData();
      $totals=[];
      $payTmpl=$model->payGroup0->payTemplate;
      $cols=$payTmpl->lineItems;
      $editables=[];
      foreach($cols as $col){
          if($col->calc_type=='open'){
             
              $editables[$col->id]=$col;
          }
      }
      
      $colsTotals=[];
      
      $colsBold=[];
      foreach($cols as $col){
          if(in_array($col->category,['BASE','G','N'])){
             
               $colsBold[$col->id]=$col;
          }
      }
      $colsBase=[];
      
   $approval_request=PayrollApprovalRequests::findOne($approval_id);   
   $i=0;
      ?>
   <div class="invoice p-3 mb-3">
                   <div class="table-responsive">
    <table   class="tbl-report"  cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
      <tr>
          <th  class="rotate"><div><div class="textH">#</div> </div></th>
            <th  class="rotate"><div><div class="textH">Employee No.</div> </div></th>
         <th class="rotate"><div><div class="textH">Employee Name</div> </div></th>
         <?php foreach( $cols as $key=>$col)  : ?>
         <?php $totals[$col->payItem->code]=0; ?> 
         <th class="rotate <?php echo isset($editables[$col->id]) && $model->status!='completed'?'editable':''; echo isset($colsBold[$col->id]) ?'strong':''; ?>"  
         <?php  echo isset($editables[$col->id]) && $model->status!='completed' ? "data-col=".$col->id.' '." data-item=".$col->item : '';?>>
             <div><div class="textH"><?php echo $col->payItem->name ?></div> </div></th>
       
          <?php endforeach;?>
      </tr>
   </thead>
<tbody>
<?php foreach($rows as $row): $i++;?>
<tr style="padding:5px ">
    <td style="padding: 5px"><?= $i ?></td>
<td style="padding: 5px"><?= $row["employee_no"] ?></td>
<td style="padding: 5px; white-space: nowrap;"><?= $row["full_name"] ?></td>
<?php foreach( $cols as $key=>$col)  : ?>
    
<td style="padding: 5px"><?= number_format($row[$col->payItem->code]) ?></td>
   <?php $totals[$col->payItem->code] = $totals[$col->payItem->code]+$row[$col->payItem->code]; ?> 
<?php endforeach;?>
</tr>
<?php endforeach ?>
    
                    </tbody>
                    
                     <tfoot>
                         <tr>
                               <th colspan="3">G.TOTAL</th>
                               
                               
                       <?php foreach( $cols as $key=>$col)  :?>
                          <th style="padding:5px "><?= number_format($totals[$col->payItem->code]) ?></th>
                          <?php endforeach ?>
                       
</tr>
</tfoot>
                 
</table>
</div>
<div style="margin: 20px;padding:10px;">
    <p style="margin-bottom:30px;text-align:left">Done at Kigali, on <?= date("d/m/Y",strtotime($model->timestamp)) ?></p>
    <p style="margin-bottom:10px;text-align:left">Prepared by:    HR Payroll Officer…………………</p>
    <ol style="margin-top:0;padding:0;list-style-position:inside">
<?php 
if(!empty($approval_request) && !empty($approval_request->getWfInstance()))
        {
        foreach($approval_request->getWfInstance()->stepInstances as $approval)
        {
            if($approval->task_type=="Approval")
            {
?>
        <li style="margin-top:50px"><?= $approval->name ?>…………………....</li>
<?php } } }?>        
        </ol>
</div>

 </div>
  





