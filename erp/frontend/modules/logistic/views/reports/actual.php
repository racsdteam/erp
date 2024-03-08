<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\bootstrap4\ActiveForm;
use common\helpers\UnitePriceHelper;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'The Actual Stock';
$this->params['breadcrumbs'][] = $this->title;

$q=" SELECT * FROM items as i  order by  i.it_sub_categ";
$com= Yii::$app->db1->createCommand($q);
$rows = $com->queryall();
?>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">

 <h3 class="card-title"><i class="fa fa-tag"></i>The Current Stock status  on <?= $date ?></h3>
  <title><i class="fa fa-tag"></i>The Current Stock status  on <?= $date ?></title>

 </div>
 <div class="card-body">
<h4>Actual Stock form</h4>
<?php
  $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); 
?>
<div class="row">
       
             
   
 
 <div class="col-xs-4">
        
                <div class="input-group">
                      <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                     <div class="form-group">
              <label> Date </label>
                  <input class="form-control date "  placeholder="Date" name="date"  value=<?php if(!empty($date))  echo $date; ?>>
               
                </div>
                  </div>   
                <!-- /.input group -->
               </div> 
      </div>
<div class="form-group">
    
 <?= Html::submitButton($model->isNewRecord ?'<i class="fa fa-search"></i> Filter':'<i class="fa   fa-edit "></i> Search', 
 ['class' =>'btn btn-primary btn btn-success']) ?>   
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
<?php ActiveForm::end(); ?>
  
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                           <th>N0</th>  
                                       <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Actual Stock</th>
                                        <th>Unite_Price / RwFrs</th>
                                        <th>Total_Price / RwFrs</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php
                                  
                                  $i=0;
                                  foreach($rows as $row):
                                   $i++;
                                     $q4=" SELECT sum(item_qty) as 'tot' FROM  items_reception as rec inner join reception_goods as gr on gr.id=rec.reception_good   where rec.status='approved' and  	item='".$row["it_id"]."'  and gr.reception_date <= '".$date."' ";
                                     $command4 = Yii::$app->db1->createCommand($q4);
                                     $row4= $command4->queryOne();
                                     $qty_in=$row4['tot'];
                                     if($qty_in!=0):
                                     $q4=" SELECT sum(out_qty) as 'tot' FROM   items_request   where	it_id='".$row["it_id"]."'  and out_status=1 and timestamp<= '".$date." 23:59:59' ";
                                     $command4 = Yii::$app->db1->createCommand($q4);
                                     $row4= $command4->queryOne();
                                     $qty_out=$row4['tot'];
                                     
                                     $qty_remaining=$qty_in-$qty_out;
                                     
                                     $unit_price=UnitePriceHelper::Calculate($row["it_id"],'2020-07-01',$date);
                                     $item_total=$qty_remaining*(float)$unit_price;
                                      $item_total_vat=$item_total+($item_total*18/100);
                                  ?>
                                   
                                   
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                     <td>  <?php echo $row["it_code"] ; ?></td>
                                     <td><?php echo $row["it_name"] ; ?></td>
                                        <td><?php echo $qty_remaining ; ?> </td>
                                         <td><?php echo number_format($unit_price) ; ?> </td>
                                         <td><?php echo number_format($item_total); ?></td>
                                        </tr>
                                    
                                    <?php 
                                     $total=$total+$item_total;
                                    endif; 
                                    endforeach;
                                    ?>
                                   </tbody>
                                   
                                    </tfoot>
                                    <tr>
                                        <td colspan="5"> <b>TOTAL</b> </td>
                                         <td > <b><?= number_format($total) ?> RwFrs </b> </td>
                                         </tr>
                                     </tfoot> 
                                </table>
 </div>
 </div>

 </div>
 
  
 </div>
 
 
 </div>

</div>
</div>
<?php
$script = <<< JS
$(document).ready(function()
		{
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

	});
JS;
$this->registerJs($script);

?>