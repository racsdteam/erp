<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\procurement\models\ProcurementCategories;
use frontend\modules\procurement\models\ProcurementMethods;
use frontend\modules\procurement\models\ProcurementPlans;
use frontend\modules\procurement\models\ProcurementActivities;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\Tenders */
/* @var $form yii\widgets\ActiveForm */

if(1<= (int) date("m") and 6>= (int) date("m")):
    $fin_year= ((int)date("y")-1)."-".date("y");
else:
    $fin_year= date("y")."-".((int)date("y")+1);
endif;
$procurement_plan= ProcurementPlans::find()->where(["status"=>"Approved"])->orderBy(['updated_at' => SORT_DESC])->one();

$procurement_activities = ArrayHelper::map(ProcurementActivities::findAll(["planId"=>$procurement_plan->id]),"code","description");
?>

<div class="tenders-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender Item Types Setting</h3>
                       </div>
               
           <div class="card-body">
           <?php if(Yii::$app->session->hasFlash('error')) {
               
               Yii::$app->alert->showError(Yii::$app->session->getFlash('error'),'error');
               
               }
           
            ?>
    <?php $form = ActiveForm::begin(); ?>
    <?=  $form->field($model, 'procurement_activity_id')->dropDownList($procurement_activities,['prompt'=>'Select ','class'=>['form-control select2'],])->label("Select Plan Activity");?>
    <?= $form->field($model, 'title') ?>
    <?=  $form->field($model, 'procurement_method_code')->dropDownList(ArrayHelper::map(ProcurementCategories::find()->all(), 'code', 'name'),['prompt'=>'Select ','class'=>['form-control select2'],])->label("Select Tender Methodes");?>
    <?=  $form->field($model, 'procurement_category_code')->dropDownList(ArrayHelper::map(ProcurementMethods::find()->all(), 'code', 'name'),['prompt'=>'Select ','class'=>['form-control select2'],])->label("Select Tender Categories");?>
    <?= $form->field($model, 'number_lots') ?>
    <?= $form->field($model, 'bid_security_amount') ?>
    <?= $form->field($model, 'tender_doc_charges_amount') ?>
    <?= $form->field($model, 'tender_doc_charges_amount') ?>
    <?= $form->field($model, 'final_destination') ?>
    <?= $form->field($model, 'bid_validity_periode') ?>
    <?=  $form->field($model, 'manufactures_authorization_status')->dropDownList(["0"=>"No","1"=>"yes"],['prompt'=>'Select ','class'=>['form-control select2'],]);?>
    <?=  $form->field($model, 'alternative_bid_status')->dropDownList(["0"=>"No","1"=>"yes"],['prompt'=>'Select ','class'=>['form-control select2'],]);?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
</div>
</div>
</div>