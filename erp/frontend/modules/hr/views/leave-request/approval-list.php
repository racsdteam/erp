<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\UserHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpPersonsInPosition;
use kartik\select2\Select2;
use frontend\modules\hr\models\LeaveCategory;
?>
<style>

.myDiv{
	display:none;
}

.next-ap-visible{
    
  display:visible;  
}

.next-ap-hidden{display:none;}

#erpmemoapproval-action label:not(:first-child){
    margin:0 10px;
}
/*styling dropdown selected otptios*/

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc !important;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px;
    color: rgba(255,255,255,0.7) !important;
}

ul.notice li{
 font-size:16px;
}
ul li.interim{
    background-color:yellow;
}



</style>
<?php
$user_id=$model->user_id;
$datetime=explode(" ",$model->timestamp);
$date=$datetime[0];
 
  $leave_category=LeaveCategory::find()->where(["id"=>$model->leave_category])->one();
  $position=ErpOrgPositions::find()->where(["position_code"=>$model->employee_position_appointment])->one();
  $person_in_position=ErpPersonsInPosition::find()->where(["position_id"=>$position->id])->one();
   $department=ErpOrgUnits::find()->where(["id"=>$person_in_position->unit_id])->one();
    $user=UserHelper::getUserInfo($user_id);

//--------------------all positions------------------------------------------------
$data=ErpOrgPositions::find()->all();



$this->title ="Insert the Approvals";
$this->params['breadcrumbs'][] = ['label' => 'Leave Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="leave-approval-view" id="leave-approval-view">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
<div class="card-body">
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
<table class="table">
    <tbody>
        <tr>
            <td colspan="7" style="width: 520.8pt;border: 1pt solid windowtext;padding: 0in 5.4pt;height: 14.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-family:"Arial",sans-serif;'>A: Personal Particulars</span></strong><span style='font-family:"Arial",sans-serif;'>:</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:110.05pt;border:solid windowtext 1.0pt;border-top:  none;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Full Name</span></p>
            </td>
            <td colspan="4" style="width:190.25pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $user['first_name'] ?>  <?= $user['last_name'] ?></span></p>
            </td>
            <td style="width:99.0pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Date</span></p>
            </td>
            <td style="width:121.5pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $date ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 110.05pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Post / Title</span></p>
            </td>
            <td colspan="4" style="width: 190.25pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $position->position ?></span></p>
            </td>
            <td style="width: 99pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Department</span></p>
            </td>
            <td style="width: 121.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 22.45pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $department->unit_name ?></span></p>
            </td>
        </tr>
         <tr>
            <td style="width:110.05pt;border:solid windowtext 1.0pt;border-top:  none;padding:0in 5.4pt 0in 5.4pt;height:25.6pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Reason:</span></p>
            </td>
            <td colspan="6" style="width: 410.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 25.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $model->reason ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 110.05pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Total <?= $leave_category->leave_category ?> entitlement</span></p>
            </td>
            <td colspan="4" style="width: 190.25pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'> <?= $leave_category->leave_number_days ?> days Financial year <?= $model->leave_financial_year ?></span></p>
            </td>
            <td style="width: 99pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>N<sup>o</sup> of Annual leave days requested</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 121.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 35.95pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->number_days_requested ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width:110.05pt;border:solid windowtext 1.0pt;border-top:  none;padding:0in 5.4pt 0in 5.4pt;height:25.6pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Remaining Annual leave days</span></p>
            </td>
            <td colspan="6" style="width: 410.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;height: 25.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?= $model->number_days_remaining ?></span></p>
            </td>
        </tr>
       
        <tr>
            <td colspan="7" style="width: 520.8pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;height: 14.6pt;vertical-align: top;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>B: <?= $leave_category->leave_category ?>  &nbsp;status</span></strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>:</span></p>
            </td>
        </tr>
        
        <tr>
            <td colspan="2" style="width:111.3pt;border:solid windowtext 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Previous Date / Number of time of <?= $leave_category->leave_category ?> in <?= $model->leave_financial_year ?> </span></p>
            </td>
            <td style="width:1.0in;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Current leave start date</span></p>
            </td>
            <td style="width:1.0in;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>End date</span></p>
            </td>
            <td style="width:45.0pt;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Type of leave</span></p>
            </td>
            <td colspan="2" style="width:220.5pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:23.15pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Employee Signature</span></p>
            </td>
        </tr>
        
        <tr>
            <td colspan="2" style="width:111.3pt;border:solid windowtext 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->request_start_date ?></span></p>
            </td>
            <td style="width:1.0in;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->request_start_date ?></span></p>
            </td>
            <td style="width:1.0in;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $model->request_start_date ?></span></p>
            </td>
            <td style="width:45.0pt;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'><?= $leave_category->leave_category ?></span></p>
            </td>
            <td colspan="2" style="width:220.5pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.25pt;">
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0in;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        </tbody>
</table>
<h3>{{title}}</h3>
 <div class="form-group">
            <label>Number of approvers</label>
<?php $approval_number= [
"0"=>"Select number of approvals",
"1"=>"Need 1 approval",
"2"=>"Need 2 approvals",
"3"=>"Need 3 approvals",
"4"=>"Need 4 approvals",
"5"=>"Need 5 approvals",
"6"=>"Need 6 approvals",
]?>
    <?= Html::dropDownList("item",null ,$approval_number, $options=['class'=>'form-control',"v-model"=>"number"]) ?>

</div>  

    	<?php
    $form = ActiveForm::begin([
        'id'=>'approver-form', 
        'method' => 'post'
       ]);
?>

<div class="card card-primary " v-for="n in items">

<div class="card-header">
                <h3 class="card-title" v-if="n!=number">Approval Number {{n}}</h3>
                   <h3 class="card-title" v-if="n==number">Final Approval</h3>
              </div>
<div class="card-body">
    <div class="row">
     <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
         
          <div class="form-group">
            <label>Recommended {{n}} </label>
    <input type="text" class="form-control" name="recommended[]" required="required" />
</div>
</div>
 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
<div class="form-group">
            <?= '<label class="control-label">Appover Position</label>';?>
          <select  class ="select2 form-control" name= 'position[]' :id="n"  onchange='getEmployee(this.value,this.id)' required="required">
              <option value="">Select Approver Position ...</option>
   <?php 
   foreach($data as $selector){
      
            echo "<option value='".$selector['id']."'>".$selector['position']."</option>"  ;
}
      ?>  
       </select>
     
    </div>
   </div>
   <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
    <div class="form-group">
            <?= '<label class="control-label">Appover Name</label>';?>
          <select  class ="Select2 form-control select2" name= 'approver[]' :id="'emp-'+n" required="required">
               <option value="">Select Approver</option>
       </select>
     
    </div>
    </div>
    </div>
</div>
    </div>
    <input type="hidden" value="<?= $model->id ?>" name="rid"/>
  <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
  <?php
   ActiveForm::end();

 ?>  

</div>
</div>
</div>
</div>
</div>
<?php
$url=Url::to(['../doc/erp-persons-in-position/get-employee-names']); 

$script2 = <<< JS

var app = new Vue({
  el: '#leave-approval-view',
  data: {
    title: ' Please number of approvers!',
   number :0,
  },
  updated() {
     
        $('.select2').select2({width:'100%'});
 
  },
  computed: {
    items: function () {
        var item= parseInt(this.number);
        if(item>=0){
      return item;
        }else{
           return 0; 
        }
    },
  }
});


 $(document).ready(function(){
      $('.select2').select2({width:'100%'});
   $('.Select2').select2({width:'100%'});
 
 });
JS;
$this->registerJs($script2);



$script1 = <<< JS



 function getEmployee(value,id)
{
    
     $.get('{$url}',{ position : value },function(data){
        
         console.log(data);
          $('#emp-'+id).html(data);
    });
   
}



JS;
$this->registerJs($script1,$this::POS_HEAD);
?>
