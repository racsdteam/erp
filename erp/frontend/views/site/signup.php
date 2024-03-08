<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
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
        
.register-box{
    
    width: 400px !important;
}

 .image-box {



  /* Here's the same styles we applied to our content-div earlier */
  color: white;
  min-height: 50vh;
  display: flex;
  align-items: center;
  justify-content: center;
   width: 100%;
  height:100%;
  
   
}

</style>

<div class="image-box bg-success">
    
  <div class="register-box  ">
   
  <div class="register-logo">
    <a style="color:#000000" href="#">Erp<b>RAC</b>PORTAL</a>
    
  </div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 5000
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
   <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

   echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 5000
                  })";
  echo '</script>';
 
  ?>
    <?php endif; ?> 
   
 <div class="card">
  <div class="card-body register-card-body">
    <p class="login-box-msg">Register a new User</p>

    
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    
     <?= $form->field($model, 'first_name', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                               
                                    <span class="far fa-user"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'FirstName']) ?>
                                


 
 <?= $form->field($model, 'last_name', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                               
                                    <span class="far fa-user"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'LastName']) ?>
                                

  <?= $form->field($model, 'phone', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                             
                                    <span class="fas fa-phone"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'Phone']) ?>
                                
                                

    
           <?= $form->field($model, 'email', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                            
                                    <span class="far fa-envelope-open"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
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
    
   
   
  
   

}



//use app\models\Country;
$positions=ErpOrgPositions::find()->all();

//use yii\helpers\ArrayHelper;
$listData2=ArrayHelper::map($positions,'id','position');

echo $form->field($model, 'subdivision',['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                          
                                    <span class="fas fa-building"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->dropDownList(
    $options,
        ['prompt'=>'Select  organizational unit','class'=>['form-control m-select2 org-unit']]
        )->label(false);


?>

<?php
echo $form->field($model, 'position',['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                           
                                    <span class="fas fa-briefcase"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->dropDownList(
        $listData2,
        ['prompt'=>'Select position','class'=>['form-control m-select2 unit-pos']]
        )->label(false);
?>

        <?= $form->field($model, 'username', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                            
                                    <span class="far fa-user"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Username']) ?>


  <?= $form->field($model, 'password', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                         
                                    <span class="fas fa-lock"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput(['autofocus' => true])
                           ->input('password', ['placeholder'=>'Password']) ?>

<?= $form->field($model, 'confirm', ['template' => '
                        <div class="input-group mb-3 col-sm-12" >
                         {input}
                            <div class="input-group-append">
                           
                                <div class="input-group-text">
                            
                                    <span class="fas fa-lock"></span>
                                </div>
                               
                            </div>{error}{hint}
                        </div>'])->passwordInput(['autofocus' => true])
                           ->input('password', ['placeholder'=>'Confirm']) ?>
 <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a class="text-success" href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
             <?= Html::submitButton('Register', ['class' => 'btn btn-success btn-raised btn-block btn-flat']) ?>
          </div>
          <!-- /.col -->
        </div>
    
     
    <?php ActiveForm::end(); ?>

 <?= Html::a('Back to Sign in  page', ['site/login'],['class' => 'text-center text-success']) ?><br>
  
  </div>
  <!-- /.form-box -->
</div>
 </div> 
    
</div>

 <?php
$url=Url::to(['erp-units-positions/populate-positions']);
$script = <<< JS

   $(document).ready(function()
                            {
                     $(".m-select2").select2({width:'80%',theme: 'bootstrap4'});
                 
            
                         $('.org-unit').on('select2:select', function (e) {
    var unit=$(this).val();
  
    $.get('{$url}',{ unit : unit },function(data){
    
    
  var select = $('.unit-pos');
                select.find('option').remove().end();
                
      select.html(data);         

//trigger change-------------otherwise not updating
$('.unit-pos').trigger('change.select2');
    });
});         
            
            
                            });
                            
                           

JS;
$this->registerJs($script);          

 ?>
            
          
            
            
          
            
           
            
            
            