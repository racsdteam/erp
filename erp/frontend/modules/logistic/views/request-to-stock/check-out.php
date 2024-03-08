<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\widgets\ActiveForm;
use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpMemoAttachMerge;
use common\models\ErpMemoRequestForAction;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;

$this->title = 'Stock OUT';
$this->params['breadcrumbs'][] = ['label' => 'Request To Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


 $q=" SELECT r.* FROM  request_to_stock as r  where r.reqtostock_id='".$model->reqtostock_id."' ";
 $com = Yii::$app->db1->createCommand($q);
 $row = $com->queryOne();


$datetime= explode(" ",$row['timestamp']);  
$date= $datetime[0];   

$q7=" SELECT * FROM items_request where request_id='".$row['reqtostock_id']."' ";
$command7= Yii::$app->db1->createCommand($q7);
$rows7 = $command7->queryAll(); 

?>

<style>


.table-b th{
  border:none;
    
    
}
  
  
  </style>
  
  <div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i>Stock OUT</h3>
                       </div>
               
           <div class="card-body">
<table  style="width:100%;" id="maintable" cellspacing="0" cellpadding="10">
<tr>
<td style="padding:20 0px" align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td style="padding:20 0px" align="center"><h3>voucher Stock</h3><br><h3>Bon de sortie magasin</h3></td>
<td style="padding:20 0px"  align="center">
   <h4><b>N0: <?=$row['reqtostock_id'] ?></b></h4><br><br>
 <h4><b>Date: <?=$date ?></b></h4><br><br>
</td>
</tr>
</table>
</div>
<div class="row">
    <div class="col-md-10 offset-md-1">
  <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>   

                               <table  class=" m-2 table-bordered  table-responsive" style="width:100%; " cellspacing="0" cellpadding="0">
                                  <thead style=" display: table-row-group">
                                        <tr>
                                        
                                        <th class="p-2">No</th>
                                        <th class="p-2">Code</th>
                                        <th class="p-2">Designation</th>
                                        <th class="p-2">Unit</th>
                                        <th class="p-2">Quantity Demand</th>
                                        <th class="p-2">Quantity Out</th>
                                         <th class="p-2">comment</th>
                                        </tr>
                                   
                                   </thead>
                                  
                                 
                                   
                                     <tbody>
                                  <?php $i=0;  $sum=0; foreach($rows7 as $row7):?>
                                   <?php 
                                   
                                   $i++; 
                                   
                                    $q11=" SELECT * FROM   items as i where i.it_id='".$row7['it_id']."' ";
                                    $com11 = Yii::$app->db1->createCommand($q11);
                                     $row11 = $com11->queryOne();
                                   
                                   ?>
                                   
                                     <tr>
                                     <td class="p-2">
                                     <?php echo   $i; ?>
                 
                                     </td>
                                            <td class="p-2"><?php echo $row11["it_code"]?></td>
                                            <td class="p-2"><?php echo $row11["it_name"] ; ?></td>
                                              <td class="p-2"><?php echo $row11["it_unit"]; ?></td>
                                          <td class="p-2"><?php echo $row7["req_qty"]; ?></td>
                                          <?php 
                                         if($row7["out_qty"]!=0)
                                         {
                                             $value=$row7["out_qty"];
                                         }else{
                                             $value=0;
                                         }
                                          ?>
                                          <td class="p-2">    <?=  
                 $form->field($modelsItem, "[{$i}]out_qty")->textInput(['autofocus' => true,'onchange'=>'checkStock($(this))' ,'value'=>$value, 'id' =>"itemsrequest-".$i."-out_qty"])->label(false)
                 ?> </td> 
                                  <td >    <?=  
                 $form->field($modelsItem, "[{$i}]comment")->textInput()->label(false)
                 ?> 
              
                 <input type="hidden" id="itemsrequest-<?= $i ?>-id" class="form-control" name="ItemsRequest[<?= $i ?>][id]" value="<?= $row7["id"] ?>">
                 
                  
                      <input type="hidden" id="itemsrequest-<?= $i ?>-it_id" class="form-control" name="ItemsRequest[<?= $i ?>][it_id]" value="<?= $row7["it_id"] ?>">
                      </td>                  
                                        </tr>
                                    
                                    <?php endforeach;?>
                                      <tbody>
                               </table>

      <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
 <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
</div>
  <?php
$script2 = <<< JS

$(document).ready(function(){

 

 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			
			
			 $(function () {
   
    $(".Select2").select2({width:'100%'});
    
 });
			

       
        });

JS;
$this->registerJs($script2);

$url=Url::to(['check-stock/check']); 

$script_1 = <<< JS

 function checkStock(selectitem)
{

var idString=selectitem.attr('id') ;
var arr= idString.split("-"); 
var  id=arr[1];

var item =document.getElementById('itemsrequest-'+id+'-it_id').value;
var quantity=document.getElementById('itemsrequest-'+id+'-out_qty').value;
if(quantity!=0)
{
     $.get('{$url}',{ item : item, quantity: quantity },function(data){
        
         data=JSON.parse(data);
          if(!data['flag'])
          {
              document.getElementById('itemsrequest-'+id+'-out_qty').value=0;
               showErrorMessage(data['message']);
          }
    });
}
}
JS;
$this->registerJs($script_1,$this::POS_HEAD);

?>
         
     
