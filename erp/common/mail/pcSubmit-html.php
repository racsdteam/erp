<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */
$request=$task->approvalRequest;
$assignee=$task->assignedTo;
$requester=$request->requester;

$taskLink = Yii::$app->urlManager->createAbsoluteUrl(['/hr/pc-approval-task-instances/view','id'=>$task->id]);
?>
<div class="task-notification">
    <p>Hello  <?= Html::encode($assignee->last_name) ?> ,</p> 
    <p><b><?= $requester->first_name .' '.$requester->last_name ?></b> has submitted Imihigo  for <?=$request->financial_year ?> in <b>ERP</b></p>
  
    <p>Follow the link below to provide Approval or Review :</p>
    <p><?= Html::a('Review/Approval Payroll Run', $taskLink) ?></p>
   
</div>
