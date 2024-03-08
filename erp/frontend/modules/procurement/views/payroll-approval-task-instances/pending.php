<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\modules\hr\models\LeaveCategory;
use common\models\UserHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Payrolls Approvals';
$this->params['breadcrumbs'][] = $this->title;

 
?>
<div class="leave-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fas fa-inbox"></i> Pending  Payrolls Approvals</h3>
 </div>
 <div class="card-body">

 <?php
 
 
 
  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
    $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
    $userposition=$userinfo['position_code'];
    $i=0;
  
   ?>
    
   


 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                         <th>Title</th>
                                          <th>Year</th>
                                         <th>Month</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($tasks)){
                                    foreach($tasks as $task):
                                   
                                      $i++;
                                      $request=$task->approvalRequest;
                                      
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($task->is_new ==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                         <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["payroll-approval-task-instances/view",'id'=>$task->id])
                                          
                                          ,['class'=>'btn-info btn-sm active action-viexw','title'=>'View request Info'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                    <td><?=$request->title?></td>      
                                     <td><?=$request->pay_period_year?></td>
                   
                     </td>
                     
                 
                     <td>
                     <?php 
                      {
                      $month=date('F', mktime(0, 0, 0, $request->pay_period_month, 1)); 
                       echo   $month;
                        
                     }
                     
                     ?></td>
                                             <td><?php 
                                             $status= $request->status;
                                             if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='expired'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             else{
                                                  $class="label pull-left bg-orange";
                                                 
                                             }
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                        </tr>

                                     
                                    
                                    <?php 
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

</div>
