<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\UserHelper;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveRequest;

use yii\db\Query;

?>
<style>

</style>




<?php  
  $user=Yii::$app->user->identity;
 
   $steps=$process->steps;
  
  ?>
  
 <div class="card card-default text-dark ">
        
        <div class="card-header ">
            <h3 class="card-title"><i class="fas fa-handshake"></i> Submit Leave Request For Approval</h3>
        </div>
               
           <div class="card-body">
               
                
      <div class="callout callout-success">
                  <h4><i class="fa fa-exclamation-circle"></i></h4>The Request will be submitted to the following approvers :
 <table id="tbl" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Approval Level</th>
                      <th>Sequence</th>
                      <th>Assigned To</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($steps as $step):?>
                    <tr>
                      <td><?php echo $step->parent->name?></td>  
                       <td><?php echo $step->parent->number?></td>  
                        <td><?php 
                        $user=UserHelper::getUserInfo($step->approver);
                        echo $user['first_name'].' '.$user['last_name']?></td>
                    </tr>
                    
                    <?php endforeach;?>
                  </tbody>
                </table>
                 
                </div>
              
                
          
  
             
 


<?php 
  
?>

                         <?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);
?>

<?= $form->field($model, 'remark')->textarea(['rows' => '6'])->label("Note For Approver") ?>
 
<?= Html::submitButton('<i class="fas fa-share"></i> Submit ', ['class' => 'btn btn-primary ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>                       
  
  
 
              </div>

 




          <?php



$script = <<< JS


 
 $(document).ready(function(){
    
 /*$('#work-form1').on('beforeSubmit', function (e) {
    
   
});
 */
               
var oTable= $('#tbl').dataTable({
      destroy:true,
      ordering: false,
      lengthChange: false,
      info: false,
      searching: false,
      paging: false,
          
          }); 
 
 });
 



JS;
$this->registerJs($script);
?>
