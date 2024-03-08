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
use common\models\ErpRequisitionType;

 
 
 
 $datetext=date("Y-m-d");
 $q=" SELECT r.*,t.type FROM erp_requisition as r inner join erp_requisition_type  as t  on r.type=t.id  
 where r.id='".$model->id."' ";
 $com = Yii::$app->db->createCommand($q);
 $row = $com->queryOne();


$datetime= explode(" ",$row['requested_at']);  
$date= $datetime[0];   

$q7=" SELECT * FROM erp_requisition_items 
where requisition_id='".$row['id']."' ";
$command7= Yii::$app->db->createCommand($q7);
$rows7 = $command7->queryAll(); 

$q77=" SELECT p.position,u.first_name,u.last_name 
FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row["requested_by"]."' and pp.status=1 ";
$command77= Yii::$app->db->createCommand($q77);
$row77 = $command77->queryOne(); 



$q8=" SELECT * from signature where user=".$row['requested_by']." ";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne(); 

//----------------------------------office unit department------------------------------------------------------------
$q11="select u.unit_name,l1.level_name,  
                      u2.unit_name as parent,l2.level_name as parent_level 
                      from erp_org_units as u 
left join erp_org_units as u2 on u2.id=u.parent_unit 
left join erp_org_levels as l1 on l1.id=u.unit_level 
left join erp_org_levels as l2 on l2.id=u2.unit_level where u.id in
(SELECT p.unit_id from erp_persons_in_position as p where p.person_id={$row['requested_by']}  and p.status=1  order by p.id DESC)";
$command11 = Yii::$app->db->createCommand($q11);
$row11 = $command11->queryOne();

$types=ErpRequisitionType::find()->all();


$q_log=" SELECT r.timestamp as date FROM erp_requisition_approval_flow  as r  where (r.approver='15' or r.approver='68') and r.status='pending' 
and  r.pr_id='".$model->id."' order by r.timestamp desc ";
$command_log= Yii::$app->db->createCommand($q_log);
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
<td style="padding:20 0px" align="right"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>
</tr>
<tr>
<td colspan="2" style="padding:20 0px,font-size:14px;" align="left"><strong><h2>REQUISITION</h2></strong></td>
</tr>
<tr>
<td colspan="2" class="text-uppercase" style="font-size:12px;" align="left" valign="top">
    
<?php if(!empty($row11['parent_level']) && $row11['parent']!='Organization' && $row11['parent_level']!='Office') :?>
    
<h4 ><b><?=$row11['parent_level']  ?>: <?=$row11['parent']  ?></b></h4><br><br>
    <?php endif;?>
 <h4><b><?=$row11['level_name']  ?>: <?=$row11['unit_name']  ?></b></h4><br><br>
 <h4><b>Date: <?=$date ?></b></h4><br><br>


</td>
</tr>

<tr>
<td  colspan="2" style="padding:15 0px;"  align="left"><h3><b>Title: <?= $row['title'] ?></b></h3></td>
</tr>
</table>


<table  class=" table  table-bordered  table-responsive tbl-custom" style="width:100%; " cellspacing="0" cellpadding="0" border="1">
                                  <thead style=" display: table-row-group">
                                        <tr>
                                        
                                        <th >No</th>
                                        <th >Designation</th>
                                        <th >Specs</th>
                                        <th >UoM</th>
                                        <th >Qty</th>
                                        <th>Badget_code</th>
                                        <th>Unit Price</th>
                                        <th>Total Amount in <?= $model->currency_type ?></th>
                                       
                                        </tr>
                                   
                                   </thead>
                                  
                                 
                                   
                                     
                                  <?php $i=0;  $sum=0; foreach($rows7 as $row7):?>
                                   <?php $i++;  ?>
                                   
                                     <tr>
                                     <td >
                                     <?php echo   $i; ?>
                 
                                     </td>
                                            <td><?php echo $row7["designation"] ; ?></td>
                                              <td ><?php echo $row7["specs"]; ?></td>
                                               <td ><?php 
                                             echo $row7["uom"];
                                            ?>
                                        
                                          </td>
                                          <td ><?php echo $row7["quantity"]; ?></td>
                                            
                                            
                                            <td ><?php 
                                             echo $row7["badget_code"];
                                            ?>
                                        
                                          </td>
                                        
                                           <td ><?php 
                                             echo number_format( str_replace(",", "", $row7["unit_price"]), 2, '.', ',');
                                            
                                             
                                            ?>
                                        
                                          </td>
                                           <td ><?php 
                                             
                                             echo number_format(str_replace(",", "", $row7["total_amount"]), 2, '.', ',');
                                             
                                             if(!empty($row7["total_amount"]))
                                             {
                                            $number=str_replace(",", "", $row7["total_amount"]);
                                            $number=(float)$number;
                                             $sum=$sum+$number;
                                             }
                                            ?>
                                          
                                          </td>
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    <tr> 
                                     <td >
                                     <?php echo   $i+1; ?>
                 
                                     </td>
                                     <td>TOTAL</td>
                                       <td></td>
                                         <td></td>
                                           <td></td>
                                             <td></td>
                                               <td></td>
                                               <td>
                                                   <?php
                                                 //echo  number_format($sum)." ".$model->currency_type;  
                                                   
                                             echo  number_format($sum, 2, '.', ',');
                                            ?>
                                               </td>
                                     
                                    </tr>
                                    
                                      

                                   
                                                                    </table>
                <div class="row">
                  
                 
                               
                      <div class=" col-xs-8" >
                      
                      
                      <?php foreach($types as $t) :?> 
     
                          <div class="col-xs-5">
                              
                             <?php if($t->id==$model->type){ echo '<span class="fa fa-square">&#xf046;</span>';}else{
  
 echo '<span class="fa fa-square">&#xf096;</span>'; } ?> <span><?php echo $t->type ?></span> 
                              
                          </div>
                      
      
  
  

        <!-- f0c8--> 


   
     
     <?php endforeach;?>   
                      
                  </div>             
                            
                    <div class=" col-xs-2" >
                      
                <p style="padding-left:-10px;">Is the tender on Procurement plan?</p>
                
               <p><span class="fa fa-square"><?php if($row['is_tender_on_proc_plan']==1){echo '&#xf046;';}else{ echo '&#xf096;'; } ?></span> Yes</p>
               <p><span class="fa fa-square"><?php if($row['is_tender_on_proc_plan']!=1){echo '&#xf046;';}else{ echo '&#xf096;'; } ?></span> No</p>   
                    
                      
                  </div> 
                  
                   
                
                </div>                                                    
                                                                    
     
                                                                    
                                                                    
<?php $user=User::findOne($row['requested_by']) ?>

 <table class="table table-bordered table-responsive tbl-custom" style="width:100%; " cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                        <th >Requested by<br> (Department Director)</th>
                                        <th>I/C Logistics (If applicable)</th>
                                          <?php if($row['requested_at'] >= "2020-10-01 07:00:00" || $row_log['date'] >= "2020-09-27 07:00:00" ): ?>
                                        <th>Approved By DHR</th>
                                        <?php  endif; ?>   
                                        <th >Budget Officer</th>
                                        <th >Approved by DF</th>
                                        <?php if($row['requested_at'] < "2020-05-06 07:00:00"): ?>
                                        <th>Approved by DMD RAC</th>
                                        <?php  endif; ?>   
                                        <th>Approved by MD RAC</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                     <tr>
                                     <td style="padding:100px 1 px;" align="center" width="18%">
                                       
                                    </td>
                                     <td  style="padding:100px 1 px;"  width="16%">
                                         
                                          
                                     </td>
                                     
                                       <?php if($row['requested_at'] > "2020-10-01 07:00:00" || $row_log['date'] >= "2020-10-01 07:00:00"): ?>
                                    <td  style="padding:100px 1 px;" align="top center" width="16%">
                                     
                                     </td>
                                       <?php  endif; ?>  
                                       
                                     <td style="padding:100px 1 px;" width="16%">
                                         
                                          
                                     </td>
                                     <td  style="padding:100px 1 px;" width="16%">
                                          
                                     </td>
                                      <?php if($row['requested_at'] < "2020-05-06 07:00:00"): ?>
                                    <td  style="padding:100px 1 px;" align="top center" width="16%">
                                      <?php if($date >= "2020-02-06"): echo "NOT APPLICABLE"; endif; ?>   
                                     </td>
                                       <?php  endif; ?>   
                                     <td style="padding:100px 1 px;" width="16%">
                                             
                                     </td>
                                            
                                        </tr>
                                    </tbody>
                                </table> 
                                
 <div class="row">
     
  <p><h4><b><u>NB:</u></b></h4></p>
 <ol>
     <li><p>Signature of I/C Logistic is only required for requisition of goods and not works or consultancy  services.</p></li>
     <li><p>If tender is not on the budget, attach memo  approved by the Chief Budget Manager.</p></li>
 </ol>   
     
 </div>                               

 
     
     
