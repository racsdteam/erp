<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\UserHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpPersonsInPosition;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveApprovalList;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Leave Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$datetime=explode(" ",$model->timestamp);
$date=$datetime[0];
 
  $position=$model->requesterPosition;
  $orgUnit=$model->requesterOrgUnit;
  $user=$model->requester;
?>
<div class="leave-request-view">
    <div class="row">
         <div class="col-md-12">
<table class="table">
    <tbody>
        <tr>
            <td style="padding:20 0px" align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
           <td style="padding:20 0px" align="right"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>

        </tr>
    </tbody>
</table>
<h1 style='margin-top:12.0pt;margin-right:0in;margin-bottom:3.0pt;margin-left:0in;font-size:21px;font-family:"Arial",sans-serif;'><span style="font-size:19px;">&nbsp;</span><span style="font-size:19px;">Leave Application Form</span></h1>
<p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-family:"Arial",sans-serif;'>&nbsp;</span></strong></p>
<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
    <tbody>
        <tr>
            <td colspan="7" style="width: 520.8pt;border: 1pt solid ;padding: 0in 5.4pt;height: 14.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-family:"Arial",sans-serif;'>A: Personal Particulars</span></strong><span style='font-family:"Arial",sans-serif;'>:</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:110.05pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Full Name</span></p>
            </td>
            <td colspan="4" style="width:190.25pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $user->first_name ?>  <?= $user->last_name?></span></p>
            </td>
            <td style="width:99.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Date</span></p>
            </td>
            <td style="width:121.5pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $date ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 110.05pt;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Post / Title</span></p>
            </td>
            <td colspan="4" style="width: 190.25pt;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $position->position ?></span></p>
            </td>
            <td style="width: 99pt;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?=ucfirst($orgUnit->type->level_name) ?></span></p>
            </td>
            <td style="width: 121.5pt;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $orgUnit->unit_name ?></span></p>
            </td>
        </tr>
         <tr>
            <td style="width:110.05pt;padding:0in 5.4pt 0in 5.4pt;height:25.6pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Reason:</span></p>
            </td>
            <td colspan="6" style="width: 410.75pt;padding: 0in 5.4pt;height: 25.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $model->reason ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 110.05pt;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Total <?= $model->category->leave_category ?> entitlement</span></p>
            </td>
            <td colspan="4" style="width: 190.25pt;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'> <?= $model->category->leave_number_days ?> days Financial year <?= $model->leave_financial_year ?></span></p>
            </td>
            <td style="width: 99pt;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>N<sup>o</sup> of Annual leave days requested</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 121.5pt;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->number_days_requested ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width:110.05pt;padding:0in 5.4pt 0in 5.4pt;height:25.6pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Remaining Annual leave days</span></p>
            </td>
            <td colspan="6" style="width: 410.75pt;padding: 0in 5.4pt;height: 25.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $model->number_days_remaining ?></span></p>
            </td>
        </tr>
       
        <tr>
            <td colspan="7" style="width: 520.8pt;padding: 0in 5.4pt;height: 14.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>B: <?= $model->category->leave_category ?>  &nbsp;status</span></strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>:</span></p>
            </td>
        </tr>
        
        <tr>
            <td colspan="2" style="width:111.3pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Previous Date / Number of time of <?= $model->category->leave_category ?> in <?= $model->leave_financial_year ?> </span></p>
            </td>
            <td style="width:1.0in;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Current leave start date</span></p>
            </td>
            <td style="width:1.0in;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>End date</span></p>
            </td>
            <td style="width:45.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Type of leave</span></p>
            </td>
            <td colspan="2" style="width:220.5pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Employee Signature</span></p>
            </td>
        </tr>
        
        <tr>
            <td colspan="2" style="width:111.3pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->request_start_date ?></span></p>
            </td>
            <td style="width:1.0in;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->request_start_date ?></span></p>
            </td>
            <td style="width:1.0in;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->request_end_date ?></span></p>
            </td>
            <td style="width:45.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->category->leave_category ?></span></p>
            </td>
            <td colspan="2" style="width:220.5pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
                <tr>
            <td colspan="7" style="width: 520.8pt;padding: 0in 5.4pt;height: 24.25pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>Leave Approvals</span></strong></p>
            </td>
        </tr>
        <?php 
        if(!empty($model->wfInstance->stepInstances))
        {
        foreach($model->wfInstance->stepInstances as $approval)
        {
         if($approval->task_type=="Approval")
         {
         $approver=UserHelper::getUserInfo($approval->assignedTo);   
         $appover_position=UserHelper::getPosition($approval->assignedTo); 
         $approver_unit=UserHelper::getOrgUnit($approval->assignedTo);
        
          
        ?>

        <tr>
            <td colspan="3" style="width:183.3pt;padding:0in 5.4pt 0in 5.4pt;height:109.05pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:200%;'><span style='font-size:13px;line-height:200%;font-family:"Arial",sans-serif;'>This application for leave is :</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:200%;'><span style='font-size:13px;line-height:200%;font-family:"Arial",sans-serif;'>Approved : 
                <?php if($approval!=null && $approval->status=="approved"){ echo '<span class="fa fa-square">&#xf046;</span>';}else{
  
 echo '<span class="fa fa-square">&#xf096;</span>'; } ?></span></p>
                <br>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;margin-top:6.0pt;line-height:200%;'><span style='font-size:13px;line-height:200%;font-family:"Arial",sans-serif;'>Declined :   
                <?php if( $approval!=null && $approval->status=="rejected"){ echo '<span class="fa fa-square">&#xf046;</span>';}else{
  
 echo '<span class="fa fa-square">&#xf096;</span>'; } ?></span></p>
            </td>
            <td colspan="4" style="width:337.5pt;padding:0in 5.4pt 0in 5.4pt;height:109.05pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:150%;'><span style='font-size:13px;line-height:150%;font-family:"Arial",sans-serif;'>Name: <?= $approver['first_name'] ?>  <?= $approver['last_name'] ?></span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:150%;'><span style='font-size:13px;line-height:150%;font-family:"Arial",sans-serif;'>Title: <?= $appover_position->position ?></span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:150%;'><span style='font-size:13px;line-height:150%;font-family:"Arial",sans-serif;'><?=$approver_unit->type->level_name?>: <?= $approver_unit->unit_name ?> </span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:150%;'><span style='font-size:13px;line-height:150%;font-family:"Arial",sans-serif;'>Signature:</span></p>
                <?php if($approval!=null && !empty($approval->completed_at)) {?>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;line-height:150%;'><span style='font-size:13px;line-height:150%;font-family:"Arial",sans-serif;'>Date: <?= $approval->completed_at?></span></p>
               <?php } ?>
            </td>
        </tr>
        <?php 
         }
        }
        }else{
        ?>
           <tr>
            <td colspan="7" style="width: 520.8pt;padding: 0in 5.4pt;height: 24.25pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>No List Of Approval</span></strong></p>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<p><br></p>
</div></div>
</div>
