<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Items;



//use dosamigos\file\FileInput;
?>
<style>
.select2 {
/*width:100%!important;*/
}
.sw-theme-arrows > ul.step-anchor > li > a, .sw-theme-arrows > ul.step-anchor > li > a:hover{
    
   color:#bbb !important; 
    
}

#items tr td .total_one,.TotalCell{background-color:#ffd9b3;font-family:"Lucida Console", Monaco, monospace, sans-serif;font-weight:bold;}
#items tr td.TotalCell{font-family:"Arial Black", Gadget, sans-serif}

th{
    text-align:center;
}

</style>

<?php
$session = Yii::$app->session;
$user=Yii::$app->user->identity;
$total=0;
$codes=ArrayHelper::map(Items::find()->all(), 'it_code', function($item){
       return $item['it_name']."/".$item['it_code'];
}) 
?>

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

 <div class="card text-dark">
        
        <div class="card-header ">
          <h3 class="card-title "><i class="fa fa-cart-plus"></i> Add Assets Code</h3>
        </div>
               
           <div class="card-body ">

       <?php if($session!=null && $session->hasFlash('error') ) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?php echo $session->getFlash('error')?>
              </div>
            
            <?php endif?>
            
            
               

<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                                //'action' => ['erp-requisition/create'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>

  <div class="table-responsive">
      <table id="items" style="width:100%" class="table-bordered table-striped">
        <thead>
         
            <tr style="padding:5px 5px">
               <th>#</th>
                <th>Item Description</th>
                <th>Specs</th>
                 <th>UoM(unit of measurement)</th>
                  <th>Quantity</th>
                   <th>Badget Code</th>
                   <th>Unit Price</th>
                   <th>Total Price</th>
             
            </tr>
        </thead>
        <tbody class="container-items2">
        
       <?php foreach ($modelsRequisitionItems as $i=>$modelRequisitionitem): ?>
             
            <tr class="item">
                
                 <td style="width:3%;" ><?=++$i?></td> 
                
                <td style="width:30%;">
                    
                     <?php  
                           $total=  $total +  str_replace(',', '', $modelRequisitionitem->total_amount);  
                            // necessary for update action.
                            if (! $modelRequisitionitem->isNewRecord) {
                               echo Html::activeHiddenInput($modelRequisitionitem, "[{$i}]id");
                            }
                            
                            echo $modelRequisitionitem->designation
                        ?> 
                 
                
                
                 
                    
                  
                </td>
                <td style="width:15%">
                 <?= 
                  $modelRequisitionitem->specs
                
                              
                 
                 ?> 
                </td>
                
                 <td style="width:5%">
                    
                    <?= 
                    
                 $modelRequisitionitem->uom
                 
                 ?> 
                </td>
                
                <td  style="width:5%" >
                    
                    <?=  
               $modelRequisitionitem->quantity
                              
                 
                 ?> 
                </td>
                
                <td>
                   <?=  
           
                              
               $form->field($modelRequisitionitem, "[{$i}]badget_code")
        ->dropDownList($codes,['prompt'=>'Select Asset Code...','class'=>['m-select2']])->label(false)
        
        ?>   
                 
                    
                </td>
                
                 <td nowrap style="width:5%">
                    
                    <?=  
                $modelRequisitionitem->unit_price
                              
                 
                 ?> 
                 </td>
                 
                  <td  nowrap style="width:10%" >
                    
                    <?=  
                $modelRequisitionitem->total_amount
                              
                 
                 ?> 
                </td>
              
               
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       
       <td align="right" colspan="7"><b>Total Price :</b></td>
      <td  class="TotalCell"><?php
     
      echo number_format( $total) ;?></td>
      
    </tr>
    
     <tr>
       <td align="right" colspan="8">
           <div class="form-group p-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
       </td>
     
      
    </tr>
  </tfoot>
    </table>
   </div> 
           
<?php ActiveForm::end(); ?>

            



</div>

</div>

 
 </div>

</div>
  <?php
$script2 = <<< JS

			 $(function () {
   
    $(".m-select2").select2({width:'100%','theme':'bootstrap4'});
    
 });
			

       
    

JS;
$this->registerJs($script2);


?>
     
