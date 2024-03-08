<?php



use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;

?>
<style>


</style>



<?php  
  $user=Yii::$app->user->identity;
  
  ?>

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>
  
 <div class="card card-default text-dark ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-share"></i> Approval Flow  Redirection</h3>
 </div>
 <div class="card-body">
   
 



<?php

    
$user=Yii::$app->user->identity->user_id;

$q9=" SELECT u.user_id,u.first_name,u.last_name, p.position FROM user as u 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where pp.status=1";

$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryAll();

$employees=ArrayHelper::map($row9, 'user_id', function($row){
    
    return $row['first_name']." ".$row['last_name']."/".$row['position'];
}) ;



?>



<?php 

                  $items=array();
                  $items['1']='Yes';
                  $items['0']='No';
                
                          
                           $form = ActiveForm::begin([
        'id'=>'redirect-form',
    
       ]);  ?>
       
        <?=$form->field($model, 'request_id')->hiddenInput(['value'=>$request_id])->label(false); ?>
        <?=$form->field($model, 'redirect_flow_id')->hiddenInput(['value'=> $f_id])->label(false); ?>
       
        <?= $form->field($model, 'employee')->dropDownList($employees, 
	        
	         ['prompt'=>'-Choose a employee-','class'=>[' form-control m-select2'],'id'=>'emp-0' ,
			  'onchange'=>'
			'])->label('Redirect To : '); ?> 
			
			<?php $model->final_approval_status=0 ?>
			
			 <?= $form->field($model, 'final_approval_status')->radioList($items)->label("Set As Final Approver");
                  
                  ?>
             <?= Html::a('<i class="fas fa-share"></i>  Redirect', ['#'], ['class'=>'btn btn-primary btn-submit active']) ?>     
                

<?php
   ActiveForm::end();
 
 ?> 


</div>    

  

</div> 
 
              </div>






          <?php
$url=Url::to(['erp-persons-in-position/get-employee-names']); 




$script = <<< JS


 
 
 $(document).ready(function(){
 
    $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
    $('.btn-submit').on('click', function(e) {
    
    e.preventDefault();
   
      Swal.fire({
  title: 'Are you sure?',
  text: "Request will be redirected !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, redirect it!'
}).then((result) => {
  if (result.value) {
  
     $("#redirect-form").submit(); 
  }
})

return false;
   
});


    
  
 
 });
 



JS;
$this->registerJs($script);
?>

