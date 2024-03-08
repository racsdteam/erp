<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\ErpOrgPositions;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgSubdivisions;
use yii\helpers\Url;

use common\models\ErpOrgLevels;

$this->context->layout='signup';
$this->title = 'Signup';

$this->params['breadcrumbs'][] = $this->title;
?>

<style>
span.select2-container--default{
width:100% !important;
    
}

.select2-selection--single {
 /* height: 100% !important;*/
   padding-right: 12px !important;
}
.select2-selection__rendered{
 word-wrap: break-word !important;
  text-overflow: inherit !important;
  white-space: normal !important;
  
}
        


</style>


    
  <div class="register-box  ">
   
  <div class="register-logo">
    <a href="../../index2.html">Erp<b>RAC</b>PORTAL</a>
  </div>

  <?php
  
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('failure')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('failure'));
   }
  
  
  ?>



  <div class="register-box-body">
    <p class="login-box-msg">Register a new User</p>

    
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


  <?= $form->field($model, 'first_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                            {input}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'FirstName']) ?>


 <?= $form->field($model, 'last_name', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-user"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'LastName']) ?>
 

     <?= $form->field($model, 'phone', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-earphone"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Phone']) ?>
                           


       <?= $form->field($model, 'email', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-envelope"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Email']) ?>


                           <?php
                           
$lvs=ErpOrgLevels::find()->all();
$options=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $options[strtoupper($l->level_name."s")]=$data;
    
   
   
   // $sbs=ErpOrgSubdivisions::find()->where(['subdiv_level'=>$l->id])->all();
   

}



//use app\models\Country;
$positions=ErpOrgPositions::find()->all();

//use yii\helpers\ArrayHelper;
$listData2=ArrayHelper::map($positions,'id','position');

echo $form->field($model, 'subdivision',['template' => '
                       
<div   class="input-group  col-sm-12">
{input}
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-briefcase"></span>
    </span>
    
</div>{error}{hint}
'])->dropDownList(
    $options,
        ['prompt'=>'Select  organizational unit','class'=>['form-control  select2 org-unit']]
        )->label(false);


?>

<?php
echo $form->field($model, 'position',['template' => '
                       
<div  class="input-group col-sm-12">
{input}
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-briefcase"></span>
    </span>
    
</div>{error}{hint}
'])->dropDownList(
        $listData2,
        ['prompt'=>'Select position','class'=>['form-control select2 unit-pos']]
        )->label(false);
?>

        <?= $form->field($model, 'username', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-user"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Username']) ?>


  <?= $form->field($model, 'password', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-lock"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->passwordInput(['autofocus' => true])
                           ->input('password', ['placeholder'=>'Password']) ?>

<?= $form->field($model, 'confirm', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-lock"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->passwordInput(['autofocus' => true])
                           ->input('password', ['placeholder'=>'Confirm']) ?>

    
      <div class="row">
        <div class="col-xs-7">
          <div class="checkbox">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-5">

         <?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-raised btn-block btn-flat']) ?>
          
        </div>
        <!-- /.col -->
      </div>
    <?php ActiveForm::end(); ?>

 <?= Html::a('Back to Sign in  page', ['site/login'],['class' => 'text-center']) ?><br>
  
  </div>
  <!-- /.form-box -->
</div>
  
    


 <?php
$url=Url::to(['erp-units-positions/populate-positions']);
$script = <<< JS

   $(document).ready(function()
                            {
                              //$(".select2").select2();
            
            $("select").select2({
 //-------------------------------------------for it to be responsive----------------------------------------------------- 
 width: '100%' 
});
                                   
            
            
                            });
                            
                            $('.org-unit').on('select2:select', function (e) {
    var unit=$(this).val();
    console.log(unit);
    $.get('{$url}',{ unit : unit },function(data){
     console.log(data);
    
  var select = $('.unit-pos');
                select.find('option').remove().end();
                
      select.html(data);         

//trigger change-------------otherwise not updating
$('.unit-pos').trigger('change.select2');
    });
});

JS;
$this->registerJs($script);          

 ?>
            
          
            
            
          
            
           
            
            
            