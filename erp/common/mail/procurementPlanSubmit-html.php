<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */
$request=$task->approvalRequest;
$assignee=$task->assignedTo;
$requester=$request->user0;

$taskLink = Yii::$app->urlManager->createAbsoluteUrl(['/procurement/procurement-plan-approvals/view','id'=>$task->id]);
?>
<div class="task-notification">
    <p>Hello  <?= Html::encode($assignee->last_name) ?> ,</p> 
    <p><b><?= $requester->first_name .' '.$requester->last_name ?></b> has submitted Annual Procurement Plan for <?= $request->fiscal_year ?> in <b>ERP</b></p>
  
    <p>Follow the link below to provide Approval or Review :</p>
    <p><?= Html::a('Review/Approve Request', $taskLink) ?></p>
   
</div>
