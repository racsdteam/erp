<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */
$request=$task->leaveRequest;
$requester=$request->requester;
$assignee=$task->assignedTo;
$taskLink = Yii::$app->urlManager->createAbsoluteUrl(['/hr/leave-approval-flow-tasks/view','id'=>$task->id]);
?>
<div class="task-notification">
    <p>Hello  <?= Html::encode($assignee->last_name) ?> ,</p> 
    <p><b><?= $requester->first_name .' '.$requester->last_name ?> </b> has submitted a leave request in <b>ERP</b></p>
     <p><b>Leave Type  : </b> <?= Html::encode($request->category->leave_category) ?></p>
     <p><b>Date From : </b><?= Html::encode(date('d/m/Y', strtotime($request->request_start_date))) ?></p>
     <p><b>Date To : </b> <?= Html::encode(date('d/m/Y', strtotime($request->request_end_date))) ?></p>
     <p><b>Days Requested : </b> <?= Html::encode($request->number_days_requested) ?></p>
      <?php
     if($request->reason != null)
     {
     ?>
     <p>Reason: <?= Html::encode($request->reason) ?>,</p>
     <?php
     }
     ?>
    
    <p>Follow the link below to approve or decline this Request:</p>
    <p><?= Html::a('Review The Request in ERP', $taskLink) ?></p>
   
</div>
