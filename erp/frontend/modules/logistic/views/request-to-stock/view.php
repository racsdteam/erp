<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpMemoAttachMerge;
use common\models\ErpMemoRequestForAction;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\UserHelper;

 $q=" SELECT r.* FROM  request_to_stock as r  where r.reqtostock_id='".$model->reqtostock_id."' ";
 $com = Yii::$app->db1->createCommand($q);
 $row = $com->queryOne();

$user=UserHelper::getUserInfo($row['staff_id']);

$datetime= explode(" ",$row['timestamp']);  
$date= $datetime[0];   

$q7=" SELECT * FROM items_request where request_id='".$row['reqtostock_id']."' ";
$command7= Yii::$app->db1->createCommand($q7);
$rows7 = $command7->queryAll(); 


$q_log=" SELECT r.timestamp as date FROM request_approval_flow  as r  where (r.approver='15' or r.approver='68') and r.status='pending' 
and  r.request='".$model->reqtostock_id."' order by r.timestamp desc ";
$command_log= Yii::$app->db1->createCommand($q_log);
$row_log = $command_log->queryOne(); 

$q_log=" SELECT r.timestamp as date FROM request_approval_flow  as r  where (r.approver='15' or r.approver='68') and r.status='pending' 
and  r.request='".$model->reqtostock_id."' ";
$command_log= Yii::$app->db1->createCommand($q_log);
$row_log = $command_log->queryOne(); 
?>

<style>


.table-b th{
  border:none;
    
    
}
  
  
  </style>

<table  style="width:100%;" id="maintable" cellspacing="0" cellpadding="10">
<tr>
<td style="padding:20 0px" align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td style="padding:20 0px" align="center"><h3>voucher Stock</h3><br><h3>Bon de sortie magasin</h3></td>
<td style="padding:20 0px"  align="center">
   <h4><b>N0: <?=$row['reqtostock_id'] ?></b></h4><br><br>
 <h4><b>Date: <?=$date ?></b></h4><br><br>
</td>
</tr>

</table>


                               <table  class=" table  table-bordered  table-responsive" style="width:100%; " cellspacing="0" cellpadding="0">
                                  <thead style=" display: table-row-group">
                                        <tr>
                                        
                                        <th >No</th>
                                        <th >Code</th>
                                        <th >Designation</th>
                                        <th >Unit</th>
                                        <th >Quantity Demand</th>
                                        <th >Quantity Out</th>
                                        
                                        </tr>
                                   
                                   </thead>
                                  
                                 
                                   
                                     
                                  <?php $i=0;  $sum=0; foreach($rows7 as $row7):?>
                                   <?php 
                                   
                                   $i++; 
                                   
                                    $q11=" SELECT * FROM   items as i where i.it_id='".$row7['it_id']."' ";
                                    $com11 = Yii::$app->db1->createCommand($q11);
                                     $row11 = $com11->queryOne();
                                   
                                   ?>
                                   
                                     <tr>
                                     <td >
                                     <?php echo   $i; ?>
                 
                                     </td>
                                            <td><?php echo $row11["it_code"]?></td>
                                            <td><?php echo $row11["it_name"] ; ?></td>
                                              <td ><?php echo $row11["it_unit"]; ?></td>
                                          <td ><?php echo $row7["req_qty"]; ?></td>
                                          <td ><?php echo $row7["out_qty"]; ?></td> 
                                         
                                        </tr>
                                    
                                    <?php endforeach;?>
                               </table>
<h3>Please sign to approved or request your demand</h3>
  <table class="table table-bordered table-responsive" style="width:100%; " cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                        <th >Requested By <br><?= $user['first_name'] ." ".$user['last_name'] ?></th>
                                        <th>First Supervisor</th>
                                        <th >Logistic manager</th>
                                        
                                          <?php if($row['timestamp'] >= "2020-10-01 07:00:00" || $row_log['date'] >= "2020-10-1 07:00:00" ): ?>
                                        <th>Approved By DHR</th>
                                        <?php  endif; ?> 
                                         <th>Director Finance</th>
                                         
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                     <tr>
                                     <td style="padding:100px 1 px;" >
                                       
                                    </td>
                                     <td  style="padding:100px 1 px;" >
                                         
                                          
                                     </td>
                                       
                                     <td  style="padding:100px 1 px;" >
                                          
                                     </td>
                                      <?php if($row['timestamp'] > "2020-10-01 07:00:00" || $row_log['date'] >= "2020-09-27 07:00:00"): ?>
                                    <td  style="padding:100px 1 px;" align="top center" >
                                     
                                     </td>
                                       <?php  endif; ?>
                                     <td  style="padding:100px 1 px;" >
                                          
                                     </td>
                                            
                                        </tr>
                                    </tbody>
                                </table> 
     
     
