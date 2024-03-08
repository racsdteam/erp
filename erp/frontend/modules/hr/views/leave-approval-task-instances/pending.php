<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\modules\hr\models\LeaveCategory;
use common\models\UserHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Requests For Leave';
$this->params['breadcrumbs'][] = $this->title;

 
?>
<div class="leave-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fas fa-inbox"></i> Pending Requests For Leave</h3>
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
                                           <th align="center">Employee</th>
                                        <th>Category</th>
                                          <th>Financial year</th>
                                         <th>Requested Days</th>
                                           <th>Starting Date</th>
                                          <th>Ending Date</th>
                                           <th>Requested</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($tasks)){
                                    foreach($tasks as $task):
                                   
                                      $i++;
                                      $leave=$task->leaveRequest;
                                      
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
                                             
                                             Url::to(["leave-approval-task-instances/view",'id'=>$task->id])
                                          
                                          ,['class'=>'btn-info btn-sm active action-viexw','title'=>'View Leave Info'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                     <td nowrap>
                                    <?=  $leave->requester->first_name ?>  <?= $leave->requester->last_name?>
                                    </td>    
                                    <td >
                                    <?= $leave->category->leave_category ?>
                                    </td>
                                    <td>
                                            <?=
                                          
                                           $leave->leave_financial_year
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                                  <?php
                                         
                                     echo  $leave->number_days_requested ;
   
                                           ?>
                                           </td> 
                                            <td>
                                                  <?php
                                         
                                     echo  $leave->request_start_date;
   
                                           ?>  
                                          
                                         </td>
                                           <td>
                                                  <?php
                                         
                                     echo  $leave->request_end_date;
   
                                           ?>  
                                          
                                         </td>
                                          <td>
                                                  <?php
                                         
                                     echo  $leave->wfInstance->started_at ;
   
                                           ?>  
                                          
                                         </td>
                                            
                                             <td><?php 
                                             $status= $leave->status;
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
