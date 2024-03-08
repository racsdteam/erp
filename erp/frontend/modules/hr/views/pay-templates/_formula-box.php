<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\modules\hr\models\PayItems;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Locations */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
 #myInput {
    padding: 15px;
    margin-bottom: -1px;
  
    background: #f1f1f1;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.075);
  }
/*.card-wrapper{font-family: 'Lato', sans-serif;}   */ 
</style>

                 <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-laptop-code"></i> Add New Formula </h3>
                       </div>
               
           <div class="card-body">

  
  
   <div class="form-group">
                       
                        <textarea  class="form-control formula-box"  name="formula" rows="3" ></textarea>
                      </div>
   
   
 <?php 
    $htmlOptions = ['class'=>'custom-select components'];
    $componetsList=ArrayHelper::map(PayItems::find()->all(),'edCode', function($c){
                            return '['.$c->edDesc.']'; 
                             
                         });
  
   
?>
<div class="form-group">
                      <input class="form-control" id="myInput" type="text" placeholder="Search..">
                      <?php echo Html::listBox('ed', '', $componetsList, $htmlOptions);  ?>
                      </div>
   


</div>
</div>
<?php

$script = <<< JS

$(document).ready(function(){
var ta = $(".formula-box");
 ta.focus();
 $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".components option").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });


 $('.components option').click(function(){
      ta.val(ta.val()+$(this).val()+' ').focus();
    //ta.append($(this).val())
});
  
     
});

 
	

JS;
$this->registerJs($script);

?>