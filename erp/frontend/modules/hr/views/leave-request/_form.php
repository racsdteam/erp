<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveSupporting;
use common\models\ErpOrgPositions;
use common\models\ErpPersonInterim;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveRequest */
/* @var $form yii\widgets\ActiveForm */
//--------------------all Items------------------------------------------------

$this_year=date("Y");
$this_month = date("m");

if($this_month>6)
{
 $this_year=$this_year+1;   
}
$one_year_ago=$this_year-1;
$two_year_ago=$this_year-2;
$this_fin_year=$one_year_ago."-".$this_year;
$previous_fin_year=$two_year_ago."-".$one_year_ago;

$fin_year=array($this_fin_year=>$this_fin_year,$previous_fin_year=>$previous_fin_year);

$user=Yii::$app->user->identity->user_id;
$employee=Yii::$app->empUtil->getEmpByUser($user);

$position=Yii::$app->muser->getPosInfo($user);
//$position_level=$position->getlevel();

$positions=ArrayHelper::map(ErpOrgPositions::find()
                              //->where(['report_to'=>$position->id])
                           ->all(), 'id', 'position') ;
$employee_interim=[];

  $emp_start_date = new \DateTime($employee->firstEmploymentDetails->start_date);
    $emp_end_date = new \DateTime(date("Y-m-d"));
   $weekends_holidays=0;
$years=(int) $emp_end_date->diff($emp_start_date)->format("%y");
$custom_leaves=['AN21','AN20','AN19','AN18','MTN','PTN'];
$leave_categories= LeaveCategory::find()->all();
$emplyee_first_start_date=$employee->firstEmploymentDetails->start_date;

foreach($leave_categories as $leave_category):
 if (in_array($leave_category->code, $custom_leaves))
  {

      if($leave_category->code=="AN21" && ($years >=9 ||$emplyee_first_start_date <= "2018-03-01") && $employee->employmentDetails->employment_type=="PERM"){
        $cotegories[$leave_category->id] = $leave_category->leave_category;
      }
       if($leave_category->code=="AN20" && ($years >=6 && $years<9 && $emplyee_first_start_date > "2018-03-01") && $employee->employmentDetails->employment_type=="PERM" ){
        $cotegories[$leave_category->id] = $leave_category->leave_category;
      }
      if($leave_category->code=="AN19" && ($years >=3 && $years<6 && $emplyee_first_start_date > "2018-03-01") && $employee->employmentDetails->employment_type=="PERM" ){
        $cotegories[$leave_category->id] = $leave_category->leave_category;
      }
      if(($leave_category->code=="AN18" && ($years <3 && $emplyee_first_start_date > "2018-03-01") && $employee->employmentDetails->employment_type=="PERM") ||  $employee->employmentDetails->employment_type !="PERM"){
        $cotegories[$leave_category->id] = $leave_category->leave_category;
      }
       if($leave_category->code=="MTN" &&  $employee->gender=="Female"  ){
        $cotegories[$leave_category->id] = $leave_category->leave_category;
      }
      if($leave_category->code=="PTN" &&  $employee->gender!="Female"  ){
        $cotegories[$leave_category->id] = $leave_category->leave_category;
      } 
  }
  else{
      $cotegories[$leave_category->id] = $leave_category->leave_category;
  }
 endforeach;
 asort($cotegories);
?>
 <?php if (Yii::$app->session->hasFlash('error')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('error');

  echo '<script type="text/javascript">';
  echo 'Swal.fire(
  "Error!",
  "'.$msg.'",
  "error");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
      <?php
                   
                    if(!$model->isNewRecord)
                    {
                        $modeliterim=ErpPersonInterim::find()->where(["leave_request_id"=>$model->id])->one();
                        if($modeliterim!=null)
                        {
                        $employee=Yii::$app->muser->getUserInfo($modeliterim->person_in_interim);
                       $position=Yii::$app->muser->getPosInfo($modeliterim->person_in_interim);
                       $model->position_interim=$position->id;
                       $employee_interim=[$employee->id=>$employee->first_name." ".$employee->last_name];
                       $model->employee_interim=$employee->id;
                        }
                    }
                        
                        ?>
<div class="leave-request-form">
<div class="row clearfix">

             <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
    <?php $form = ActiveForm::begin(); ?>
       <div class="card-body">
  
         <?= $form->field($model, 'leave_category')
        ->dropDownList($cotegories,['prompt'=>'Select type...','class'=>['form-control select2'],])?>
        
            <?= $form->field($model, 'leave_financial_year')
        ->dropDownList($fin_year,['prompt'=>'Select type...','class'=>['form-control select2']])?>

      <div class="d-none" id=""> testdetet</div>
 <div class="form-group">
             

                <div class="input-group ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                <!-- /.input group -->
              
                  <?= $form->field($model, 'request_start_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'starting date...']]) ?>
             </div>      
       
                  <?= $form->field($model, 'number_days_requested')->textInput(['maxlength' => true,'class'=>['form-control pull-right','placeholder'=>'Number Of Days to request...']]) ?>
                
      
 <?php //if( $position_level=='manager' || $position_level=='Director'): ?>      
   <?= $form->field($model, 'position_interim')
        ->dropDownList($positions,   ['prompt'=>'-Choose an option-','class'=>[' form-control select2'],'id'=>'10',
			   'onchange'=>'getEmployee(this.value,this.id)'])?>
        
        <?= $form->field($model, 'employee_interim')
        ->dropDownList($employee_interim, ['prompt'=>'-Choose a employee-','class'=>['form-control select2 '],'id'=>'emp-10',])?>
          
<?php // endif; ?>
    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

                   
                  <h3 class="border-bottom border-gray pb-2">Upload Supporting Doc(s) if available</h3>   
                
                    <?php
                   
                    if(!$model->isNewRecord){
                        
                     $docs1=LeaveSupporting::find()->where(['leave_request_id'=>$model->id])->all(); 
                     $preview1=array();
                        $config_prev1=array();
                     
                     if(!empty($docs1)){
                         
                         foreach($docs1 as $doc1){
                             
                             $preview1[]=Yii::$app->request->baseUrl.'/'.$doc1->doc;
                             $config1=(object)[type=>"pdf",  caption=>$doc1->doc, key=>$doc1->id, 
                             'url' => \yii\helpers\Url::toRoute(['leave-request/doc-delete','id'=>$doc1->id])];
                             $config_prev1[]=$config1;
                         }
                     }
                        
                    }
                   
                    
                    ?>
                  
                 
                  
                  
                  <?= $form->field($LeaveSupporting, 'attach_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true
                                                ],
                                                 'pluginOptions'=>[
                                                     'theme'=>'fas',
                                'previewFileType' => 'image',
                                'allowedFileExtensions'=>['pdf','jpg'],
                                'showCaption' => true,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-success',
                                'browseLabel' => ' Browse file(s)',
                                'browseIcon' => '<i class="far fa-folder-open"></i>',
                                'removeClass' => 'btn btn-danger btn-sm',
                                'removeLabel' => ' Delete',
                                'removeIcon' => '<i class="far fa-trash-alt"></i>',
                                'previewSettings' => [
                                    'image' => ['width' => '138px', 'height' => 'auto']
                                ],
                               'initialPreview'=>!empty($preview1)?$preview1:[],
                                                 'overwriteInitial'=>true,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>$config_prev1,
                                                 'purifyHtml'=>true,
                                                 'uploadAsync'=>false,
                               
                            ]
                        ])?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
<?php
$url1=Url::to(['leave-info/get-leave-balance']);
$script2 = <<< JS

$(document).ready(function(){
let remaining_days;
let frequency;
 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true,
				minDate : new Date(),
				disabledDays: [6,7],
			});
$('#leaverequest-leave_financial_year').on('change', async function() {
          const category =$('#leaverequest-leave_category').val();
    const financial_year =$('#leaverequest-leave_financial_year').val();
    const user_id  ={$user} ;
    
    let days=0;
    if(category && financial_year)
    {
    const data={user_id,category,financial_year}
    await $.get('{$url1}',data,function(result){
        result=JSON.parse(result);
        //console.log(result);
        remaining_days=parseInt(result.balance);
        frequency=parseInt(result.frequency);
        if(frequency>0)
        {
        if(remaining_days>0)
        {
        toastr.info("You are remainig with <b>"+remaining_days+" days</b>.");
            
        }else{
           $('#leaverequest-leave_category').val("0").change();
           $('#leaverequest-leave_financial_year').val("0").change();
           toastr.error("<b>You don't have days for this leave category</b>."); 
           
        }
        }else{
             $('#leaverequest-leave_category').val("0").change();;
           $('#leaverequest-leave_financial_year').val("0").change();;
           toastr.error("<b>You have exceded the number of request in this leave category</b>."); 
        }
    });
   
    }
    
});

$('#leaverequest-leave_category').on('change', async function() {
          const category =$('#leaverequest-leave_category').val();
    const financial_year =$('#leaverequest-leave_financial_year').val();
    const user_id  ={$user} ;
    
    let days=0;
    if(category && financial_year)
    {
    const data={user_id,category,financial_year}
    await $.get('{$url1}',data,function(result){
             result=JSON.parse(result);
        //console.log(result);
        remaining_days=parseInt(result.balance);
        frequency=parseInt(result.frequency);
        if(frequency>0)
        {
        if(remaining_days>0)
        {
        toastr.info("You are remainig with <b>"+remaining_days+" days</b>.");
            
        }else{
           $('#leaverequest-leave_category').val("0").change();
           $('#leaverequest-leave_financial_year').val("0").change();
           toastr.error("<b>You don't have days for this leave category</b>."); 
           
        }
        }else{
             $('#leaverequest-leave_category').val("0").change();;
           $('#leaverequest-leave_financial_year').val("0").change();;
           toastr.error("<b>You have exceded the number of request in this leave category</b>."); 
        }
    });
   
    }
    
});

$('#leaverequest-number_days_requested').on('change', async function() {
          const number_days =$('#leaverequest-number_days_requested').val();

        if(number_days > remaining_days)
        {
    
           $('#leaverequest-number_days_requested').val("").change();
           toastr.error("The Number of day have to be less than <b> "+remaining_days+" days  </b>. "); 
           
        }
    
});
			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			
			
			 $(function () {
   
    $(".select2").select2({width:'100%'});
    
 });

        });

JS;
$this->registerJs($script2);
$this->registerJs($script3);

$url=Url::to(['../doc/erp-persons-in-position/get-employee-names']); 
$url1=Url::to(['leave-category/get-days']); 
$script_1 = <<< JS



 function getEmployee(value,id)
{
    
     $.get('{$url}',{ position : value },function(data){
        
         
          $('#emp-'+id).html(data);
    });
   
}

JS;
$this->registerJs($script_1,$this::POS_HEAD);


?>