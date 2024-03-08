<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user common\models\User */
$request=$task->approvalRequest;
$assignee=$task->assignedTo;
$requester=$request->requester;

$taskLink = Yii::$app->urlManager->createAbsoluteUrl(['/hr/payroll-approval-task-instances/view','id'=>$task->id]);
?>
<div class="task-notification">
    <p>Hello  <?= Html::encode($assignee->last_name) ?> ,</p> 
    <p><b><?= $requester->first_name .' '.$requester->last_name ?></b> has submitted Payroll Approval Request for <?= date("F", mktime(0, 0, 0, $request->pay_period_month, 10))
    ." ".$request->pay_period_year ?> in <b>ERP</b></p>
  
    <p>Follow the link below to provide Approval or Review :</p>
    <p><?= Html::a('Review/Approval Request', $taskLink) ?></p>
   
</div>
