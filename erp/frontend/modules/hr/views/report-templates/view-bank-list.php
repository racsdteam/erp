<?php
use frontend\modules\hr\models\PayrollApprovalRequests;
use frontend\modules\hr\models\EmpBankDetails;
use frontend\modules\hr\models\EmpPaySplits;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
?>
  <h3 style="text-align:center"><?php echo $model->rpt_desc; ?></h3>
          <?php 
   
         $totBase=0;
         $totEE=0;
         $tot=0;
         $i=0;
        
         
         $approval_request=PayrollApprovalRequests::findOneContainsReport($model->id);
         $period_month=ArrayHelper::getValue($model->getParams(), 'period_month');
         $period_year=ArrayHelper::getValue($model->getParams(), 'period_year');
         $splitArr=array();
         
         //------------to be made dyanamic----bank account by salary type-------
        
            foreach ($rows as $key => $r) {
            
            $account=EmpBankDetails::findByEmpAndRef($r['employee_id'],ArrayHelper::getValue($model->getParams(), 'pay_type'));
            $rows[$key]["bank_name"] =empty($account)?"":$account->bank->sort_code."-".$account->bank->name;
            $rows[$key]["bank_account"] =empty( $account)?"": $account->bank_account;
         
            if(!empty($pay_splits=EmpPaySplits::findActiveSplits($r['employee_id'],$period_year,$period_month))){
                 
                 $splitArr=array_merge($splitArr,$pay_splits);
                 
                 foreach($pay_splits as $key2=>$s){
                 
                 $pay_splits[$key2]->split_value=$s->calcAmount($r['crAmount']);
                  }   
                 $tot_split  = array_reduce(ArrayHelper::getColumn(ArrayHelper::toArray($pay_splits), 'split_value'), function ($previous, $current) {
                              return $previous + $current;
   
                              });
                 $rows[$key]["crAmount"] =round($r['crAmount']-$tot_split); 
             
             
                
            }else{
                
             $rows[$key]["crAmount"] =round($r['crAmount']);    
             }
          
} 

if(!empty($splitArr)){
  
  $newRows=array();

foreach($splitArr as $key=>$split){
    
 $newRow['name']=$split->acc_holder_name;
 $newRow["bank_name"] =empty($split->bank)?"":$split->bank->sort_code." - ".$split->bank->name;
 $newRow["bank_account"] =empty($split->bank)?"": $split->acc_number;
 $newRow["crAmount"]=round($split->split_value);
 $newRow["rec_acc"] =ArrayHelper::getValue($rows[0], 'rec_acc');
 $newRows[]=$newRow;

 }
 $rows=array_merge($rows,$newRows);  
    
}


ArrayHelper::multisort($rows, ['bank_name', 'crAmount'], [SORT_ASC, SORT_DESC]);

        ?>
        
  <div class="table-responsive">
 <table  class="table table-bordered tbl-report" cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
      <tr>
          <th class="rotate text-left">S/N</th>
          <th class="rotate text-left">RESERVED</th>
         <th  class="rotate text-left">BENEFICIARY NAME</th>
         <th  class="rotate text-left">BANK NAME</th>
         <th  class="rotate text-left"> BENEFICIARY ACCOUNT NUMBER</th>
         <th  class="rotate text-left">CREDIT AMOUNT (RWF)</th> 
        <th class="rotate text-left">NARRATION</th> 
        <th class="rotate text-left">RECONCILIATION ACC</th>
        <th class="rotate text-left">RESERVED</th> 
         
      </tr>
   </thead>
 <tbody>       
  <?php foreach( $rows as $row): $i++;?> 
                <tr class="rpt-row"> 
                 <td><?= $i?></td>
                 <td class="data-cell" nowrap></td>
                 <td class="data-cell" nowrap> <?=$row['name']?></td>
                 <td class="data-cell" nowrap> <?=$row['bank_name']?></td>
                 <td class="data-cell" nowrap> <?=$row['bank_account']?></td>
                 <td class="data-cell" nowrap> <?php $totEE+=round($row['crAmount']) ; echo number_format($row['crAmount']);?></td>
                 <td class="data-cell" nowrap> <?=$model->reference()?></td>
                 <td class="data-cell" nowrap> <?=$row['rec_acc']?></td>
                 <td class="data-cell" nowrap></td>
                 
                 
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr>
<th colspan="5" class="text-left">TOTAL</th>   

<th class="total text-left"><?php echo number_format($totEE)?></th> 
<th colspan="3" class="text-left"></th>
</tr>
</tfoot>
</table>
</div>

<div style="margin: 20px;padding:10px;">
     <p style="margin-bottom:30px;text-align:left">Done at Kigali, on <?= date("d/m/Y",strtotime($model->timestamp)) ?></p>
    <p style="margin-bottom:10px;text-align:left">Prepared by:    HR Payroll Officer…………………</p>
    
    
<?php if(!empty($approval_request) && !empty($approval_request->getWfInstance())) : ?>

<?=$this->render('/report-templates/_approval',['model'=>$model,'wf'=>$approval_request->getWfInstance()]) ?>
<?php endif;?>
</div>      

 
     
     
