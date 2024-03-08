<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

?>

<style>
    
      

.edTable  th, .edTable  td {
    border: 1px solid #dee2e6;
   /* border: 1px solid black;*/
    border-collapse:collapse;
}

h4 {
 
 
  border-bottom: 2px solid black ;

}

    
</style>

<?php
                   $e=$model->employee0;
                   
                   $unit= $model->empUnit;
                   $pos= $model->empPosition;
                   $payPeriod=$model->payPeriod;
                   $slipItems=$model->getSlipItems();
                  
                     $arr=array();
                     $ded_arr=array();
                     $earn_arr=array();
                   
                       
                     foreach($slipItems as $item){
                            
                            $arr[$item['edCateg']][]=$item;
                        }
                    
                     foreach($arr['ENG'] as $en){
                            
                             if(!empty($en['amount']))
                              $earn_arr[]=['edDesc'=>$en['edDesc'],'amount'=>$en['amount']];
                        }
                      
                     foreach($arr['DED'] as $ded){
                              if(!empty($ded['amount']))
                             $ded_arr[]=['edDesc'=>$ded['edDesc'],'amount'=>$ded['amount']];
                        }  
                        
                  
                
                 
                   $tot_en=0;
                   $tot_ded=0;
                   $tot_en+=$model->basic;

?>


<div class="invoice p-3 mb-3 text-dark">
    
<div class="row">  
<div class="col-sm-12">
                   
               <img class="float-left" src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px">    
               <img class="float-right" src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px">    
               </div> 
               </div>  
 
 <div class="row invoice-info">
 
 <div class="col-sm-12 invoice-col">
     
  <h4 class=" text-center mb-3"><b>Pay Slip for Month of <?= date("F", mktime(0, 0, 0, $payPeriod->pay_period_month, 10)).' '.$payPeriod->pay_period_year ?></b></h4>
  
     
 </div>             
               
        <div class="col-sm-12 invoice-col mb-3">
                  <b>Employee No:</b> <?= $e->employee_no ?><br>
                  <b>Employee Name:</b> <?= $e->first_name.' '.$e->last_name ?><br>
                  <b>Department/Unit:</b> <?= $unit->unit_name ?><br>
                  <b>Position:</b> <?=$pos->position ?><br>
                 
                </div>
               
              </div>
             <div class="row">
                <div class="col-12 table-responsive">
                  <table border="0" class="edTable "  width='100%'>
                    <thead>
                    <tr>
                      <th colspan="2" ><span class="float-left">Earnings</span><span class="float-right">Amount</span></th>
                      
                      <th colspan="2"><span class="float-left">Deductions</span><span class="float-right">Amount</span></th>
                     
                     
                    </tr>
                    </thead>
                    <tbody>
                     <tr>
                     
                     <td colspan="2" style="vertical-align: top;">
                        <table border="0" cellspacing="0" cellpadding="0"  width='100%'>
                        <tr>
                       <td style='border:none;'>Basic Pay</td>
                       <td style='border:none;' class="text-right"><?=number_format($model->basic)?></td>
                      
                        </tr>   
                          <?php foreach($earn_arr as $key=>$en) :?>
                       <tr>
                       <td style='border:none;'><?=$en['edDesc']?></td>
                       <td style='border:none;' class="text-right"><?=number_format($en['amount'])?></td>
                       <?php $tot_en+=$en['amount']; endforeach?>
                        </tr>    
                        </table>
                     
                     </td>    
                     <td colspan="2" style="vertical-align: top;">
                        <table border="0" cellspacing="0" cellpadding="0" width='100%'>
                            <tr>
                               <?php foreach($ded_arr as $key=>$ded) :?>
                       <td style='border:none;'><?=$ded['edDesc']?></td>
                       <td style='border:none;' class="text-right"><?=number_format($ded['amount'])?></td>
                         </tr>
                       <?php $tot_ded+=$ded['amount']; endforeach?>  
                            
                        </table>  
                         
                     </td>    
                         
                     </tr>   
                  
                     <tr>
                        <th colspan="2" ><span class="float-left">Gross Salary</span><span class="float-right"><?php echo number_format($tot_en); ?></span></th>
                         <th colspan="2" ><span class="float-left">Total Deductions</span><span class="float-right"><?php echo number_format($tot_ded); ?></span></th>
                        
                     </tr>
                     
                      <tr>
                        <td colspan="2"></td>   
                         <th colspan="2" ><span class="float-left">Net Salary</span><span class="float-right"><?php echo number_format($tot_en-$tot_ded)?></span></th> 
                         
                     </tr>
                  
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
          

</div>
                            

 
     
     
