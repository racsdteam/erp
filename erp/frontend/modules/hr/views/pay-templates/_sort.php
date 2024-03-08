<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItems;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .custom-checkbox{margin-right:15px;}
    
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                  <?php 
   
    
     $lineItems = $model->lineItems;  
    ?>
    
                  <?php $form = ActiveForm::begin(['id'=>'sort-form']); ?>
                 
                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-sort"></i> Sort  Pay Items</h3>
                            <div class="card-tools">
                 
              <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                     
                       <?= Html::submitButton('Save', ['class' => 'btn btn-primary ']) ?>
                    </li>
                   
                  </ul> 
                  
                  
                 
                </div>
                       </div>
               
           <div class="card-body">
      
             
               
  <input type = "hidden" name="row_order" id="row_order" />  
    
  <ul class="todo-list ui-sortable" data-widget="todo-list">
                 
         <?php if(!empty($lineItems)) foreach($lineItems as $lineItem) :?> 
           
           
            <li id=<?php echo $lineItem->id; ?> >
                    <!-- drag handle -->
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                
                   
                    <!-- todo text -->
                    <span class="text"><?php echo $lineItem->payItem->name?></span>
                   
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
           
           <?php endforeach?>
                 
                 
                 
                </ul>
                
          

    
</div>
</div>

<?php ActiveForm::end(); ?>
</div>
</div>



<?php

$script = <<< JS

 $(document).ready(function(){

// jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle,.ui-sortable',
    forcePlaceholderSize: true,
    zIndex              : 999999
  })
     
$('#sort-form').on('beforeSubmit', function (e) {
    if (!confirm("Do you want to save order changes. Save?")) {
        return false;
    }
    
    var selectedItems = new Array();
	$('ul.ui-sortable li').each(function() {
	selectedItems.push($(this).attr("id"));
	});
	document.getElementById("row_order").value = selectedItems;
	console.log(document.getElementById("row_order").value)
    return true;
});
     
});

JS;
$this->registerJs($script);

?>
