<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use common\models\ErpMemo;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Memos';
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
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-boxes"></i> My Memo(s)</h3>
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
    
 $q=" SELECT distinct(f.memo_id),f.timestamp  FROM erp_memo_approval_flow as f
 where (f.originator='".Yii::$app->user->identity->user_id."' or (f.approver='".Yii::$app->user->identity->user_id."' and f.status='archived' )) and f.memo_id!=0  order by f.timestamp desc ";
 $com = Yii::$app->db->createCommand($q);
$rows = $com->queryAll();
$i=0;
    
 //var_dump($rows) ;  
    ?>
 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                         <th align="center">Actions</th>
                                        <th>#Memo Number#</th>
                                          <th>Title</th>
                                          <th>Memo Type</th>
                                          <th>Created By</th>
                                          <th>Status</th>
                                          
                                          <th>Ownership Status</th>
                                         
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row):
                              $model=ErpMemo::findOne($row['memo_id']);
      if($model!=null)
      {
     $i++;                              
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                           </td>
                                           
                                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["erp-memo/view-pdf",'id'=>$model->id,'flow'=>$row['id']])
                                          
                                          ,['class'=>'btn btn-info btn-sm  action-viexw','title'=>'View Memo Info'] ); ?> 
                                            
                                          
                                          <?=Html::a('<i class="fa fa-recycle"></i> Histroy',
                                             Url::to(["erp-memo/memo-tracking",'id'=>$model->id
                                           ])
                                          ,['class'=>'btn btn-primary btn-sm  action-view','title'=>'Memo tracking History' ] ); ?>
                                           
                                                 
                                                 
                                         
                         </div>
                                   
                                          </td >
                                    <td nowrap>
                                        
                                        
                                        <?= Html::a('<i class="fa  fa-file-text-o"></i>'." ".$model->memo_code,
                                        Url::to(['erp-memo/view-pdf','id'=>$model->id]), ['class'=>'']) ?> 
                                        
                                        
                                        </td>
                                   
                                          
                                          
                                        
                                    
                                    <td>
                                            <?=
                                           $model->title
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                            <?php
                                          
                                          
                                           if( $model->categ->categ_code=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if($model->categ->categ_code=='TR'){
                                         $label='Travel Request';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fas fa-plane"></i>';
                                     }
                                      else if( $model->categ->categ_code=='RFP'){
                                         $label='Request For Payment';  
                                         $class="label pull-left bg-orange";
                                         $fa='<i class="fa fa-money"></i>';
                                     }
                                     else if($model->categ->categ_code=='O'){
                                         $label='Other';  
                                         $class="label pull-left bg-purple";
                                         $fa='<i class="fa fa-file-o"></i>';
                                     }
                                     else{
                                          $label=$model->categ->categ_code;
                                          $fa='<i class="fa fa-file-o"></i>';
                                          $class="label pull-left bg-pink";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';
                                           
                                           
                                            
                                           ?>
                                          
                                          
                                         </td>
                                         
                                        
                                           <td><?php 
                                          
                                           $creator=$model->creator; 
                                           
                                          $full_name=$creator->first_name." ".$creator->last_name; 
                                          $pos=$creator->findPosition();
                                            
                                           echo $full_name." [".$pos['position']." ]"; 
                                           
                                           ?></td>
                                    
                                            
                                             <td><?php 
                                             $status= $model->status;
                  
                                             if($status=='approved'){
                                                
                                                $class="label pull-left bg-green";    
                                             }
                                             
                                            else if( $status=='processing' || $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                                 
                                             }else if($status=='expired'){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }else {
                                                 $class="label pull-left bg-orange";
                                                 
                                                 
                                             }
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                            
                                             
                                             
                                        <td>
                                            <?php
                                               $user= Yii::$app->user->identity->user_id;
                                         if( $user==$model->created_by){
                                                 
                                                 $class="label pull-left bg-info";
                                                 echo '<small style="padding:5px;border-radius:13px;" class="'.$class.'">Owner</small>';
                                             }
                                             else{
                                                 $class="label pull-left bg-secondary";
                                                 
                                                    echo '<small style="padding:5px;border-radius:13px;" class="'.$class.'">Shared with me</small>';
                                             }
                                             
                                          
                                             
                                         
                                            
                                           ?>
                                          
                                          
                                         </td>
                                                   
                          
                                        </tr>

                                     
                                    
                                    <?php 
      }
                                    endforeach;
                                    }
                                    ?>
                                       
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



