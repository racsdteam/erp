<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Purchase Requisitions';
$this->params['breadcrumbs'][] = $this->title;

  

?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fab fa-opencart"></i> My Purchase Requisition(s)</h3>
 </div>
 <div class="card-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<?php  


//---------------------------------my req----------------------------------------------------------------

 $q1=" SELECT DISTINCT(pr_id) FROM erp_requisition_approval_flow  as f  inner join erp_requisition as pr on pr.id=f.pr_id
 where  f.originator='".Yii::$app->user->identity->user_id."' 
 or (f.approver='".Yii::$app->user->identity->user_id."' and (f.status='done' or f.status='completed' )) or pr.requested_by='".Yii::$app->user->identity->user_id."' 
 order by f.pr_id desc";
 $com1 = Yii::$app->db->createCommand($q1);
 $rows = $com1->queryAll();

?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                         <th>Actions</th>
                                        <th>PR Number</th>
                                        <th>Requisition For</th>
                                        <th>Title</th>
                                         <th>Tender On Proc Plan</th>
                                        <th>Status</th>
                                        
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row1):?>
                                    <?php 
                                     
    $q=" SELECT pr.*,t.type as pr_type FROM erp_requisition as pr inner join erp_requisition_type as t on t.id=pr.type
   
   where pr.id='".$row1['pr_id']."' ";
        $com = Yii::$app->db->createCommand($q);
        $row = $com->queryOne();
                                     $i++;
                                    ?>
                                    
        
                                    <tr class="<?php if($row1['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                           
                                                                                                          <td nowrap>
                                              
                                              
                                              <div style="text-align:center" class="centerBtn">
     
     
     
                                                                          
        <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-requisition/view-pdf",'id'=>$row['id'],'status'=>$row["approve_status"],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Purchase Requisition Info']); ?>
                                        
     
                                            
                                            <?=Html::a('<i class="fa fa-recycle"></i> History',
                                              Url::to(["erp-requisition/doc-tracking",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-view','title'=>'View Requisition Info work flow' ,'disabled'=>$row["approve_status"]!='drafting'] ); ?> 
                                          </div>
    </td> 
                                  <td nowrap><?= Html::a('<i class="fab fa-opencart"></i>'." ".$row["requisition_code"],Url::to(['erp-requisition/view-pdf','id'=>$row["id"]]), ['class'=>'pr_code']) ?></td>
                                 
                                 
                                         <td>
                                            <?php 
                                         
                                       echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.$row["pr_type"].'</small>';
                                         
                                          ?>
                                          
                                          
                                            <td>
                                            <?=
                                           $row["title"] ;
                                            
                                           ?>
                                          
                                         </td>
                                          
                                         </td>
                                         
                                       
                                            

                                            <td><?php  
                                            
                                            if($row['is_tender_on_proc_plan']){
                                                
                                               echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. "Yes".'</small>';  
                                            }else{
                                                
                                              echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-red">'. "No".'</small>';     
                                            }
                                            
                                            ?></td>
                                            
                                            <td><?php  
                                             if($row["approve_status"]=='processing' || $row["approve_status"]=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='drafting'){
                                                  $class="label pull-left bg-graw";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px;" class="'.$class.'">'. $row["approve_status"].'</small>'; ?></td>
                                            
                          
                                        
                                     
                                        </tr>

                                     
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                </table>

                                 </div>

 </div>

 </div>
 
 
 </div>

</div>



        <?php
   
$script = <<< JS

 

JS;
$this->registerJs($script);



?>



