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

$this->title = 'The Inventory Report from '.$sdate." to ". $edate ;
$this->params['breadcrumbs'][] = $this->title;

$q=" SELECT * FROM items as i  order by  i.it_sub_categ";
$com= Yii::$app->db1->createCommand($q);
$rows = $com->queryall();
?>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">

 <h3 class="card-title"><i class="fa fa-tag"></i>The Inventory Report  from <?= $sdate ?> to<?= $edate ?> </h3>
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
              <label> Start Date </label>
                  <input class="form-control date "  placeholder="Start date" name="sdate"  value=<?php if(!empty($sdate))  echo $sdate; ?>>
               
                </div>
                  </div>   
                <!-- /.input group -->
               </div> 
                <div class="col-xs-4">
        
                <div class="input-group">
                      <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                     <div class="form-group">
              <label> Start Date </label>
                  <input class="form-control date "  placeholder="End date" name="edate"  value=<?php if(!empty($edate))  echo $edate; ?>>
               
                </div>
                  </div>   
                <!-- /.input group -->
               </div> 
      </div>
<div class="form-group">
    
 <?= Html::submitButton($model->isNewRecord ?'<i class="fa fa-search"></i> Filter':'<i class="fa   fa-edit "></i> Search', 
 ['class' =>'btn btn-primary btn btn-success']) ?>   
</div>
<?php ActiveForm::end(); ?>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                           <th>N0</th>  
                                       <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Initial QT</th>
                                        <th>Received QT</th>
                                        <th>Used QT</th>
                                        <th>Balance QT</th>
                                        <th>Unit Price</th>
                                        <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php
                                  
                                  $i=0;
                                  if(!empty($sdate)&& !empty($edate))
                               {
                                  foreach($rows as $row):
                                   $i++;
                                      $unit_price=UnitePriceHelper::Calculate($row['it_id'],$sdate,$edate);
                                     // var_dump($edate2);die();
                                      if($unit_price==0)
                                      {
                                            $q4=" SELECT *  FROM  items_reception   where 	item='".$row['it_id']."' 
                                            and status='approved'  order by timestamp desc";
                             $command4 = Yii::$app->db1->createCommand($q4);
                            $row4= $command4->queryOne();
                                   $total_price=$row4['total_price'];
                                   $item_qty=$row4['item_qty'];
                                   if($item_qty!=0)
                                   $unit_price=$total_price/$item_qty;
                                   else
                                   $unit_price=0;
                                      }
                                     $q4=" SELECT sum(item_qty) as 'tot' FROM  items_reception as rec inner join reception_goods as gr on gr.id=rec.reception_good   where rec.status='approved' and  	item='".$row["it_id"]."'  and gr.reception_date <= '".$sdate."'  ";
                                     $command4 = Yii::$app->db1->createCommand($q4);
                                     $row4= $command4->queryOne();
                                     if($row4['tot']>=0)
                                     $initial_in =$row4['tot'];
                                     else
                                     $initial =0;
                                    $q4=" SELECT sum(out_qty) as 'tot' FROM   items_request   where	it_id='".$row["it_id"]."'  and out_status=1 and timestamp < '".$sdate." 00:00:00' ";
                                      $command4 = Yii::$app->db1->createCommand($q4);
                                     $row4= $command4->queryOne();
                                     if($row4['tot']>=0)
                                     $initial_out =$row4['tot'];
                                     else
                                     $initial =0;
                                     if($initial_in>=$initial_out)
                                     {
                                         $initial=$initial_in-$initial_out;
                                     }
                                     else{
                                         $initial=0;
                                     }
                                     
                                     $q4=" SELECT sum(item_qty) as 'tot' FROM  items_reception as rec inner join reception_goods as gr on gr.id=rec.reception_good   where rec.status='approved' and  	item='".$row["it_id"]."'  and  gr.reception_date between '".$sdate." 00:00:00' and '".$edate." 23:59:59' ";
                                     $command4 = Yii::$app->db1->createCommand($q4);
                                     $row4= $command4->queryOne();
                                     if($row4['tot']>=0)
                                     $recieved =$row4['tot'];
                                     else
                                     $recieved =0;
                                     
                                   
                                     $q4=" SELECT sum(out_qty) as 'tot' FROM   items_request   where	it_id='".$row["it_id"]."'  and out_status=1 and timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  ";
                                     $command4 = Yii::$app->db1->createCommand($q4);
                                     $row4= $command4->queryOne();
                                     if($row4['tot']>=0)
                                     $out=$row4['tot'];
                                     else
                                     $out=0;
                                     $balance=$initial+$recieved-$out;
                                      $intem_total=$balance*(int)$unit_price;
                                  ?>
                                   
                                   
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                     <td>  <?php echo $row["it_code"] ; ?></td>
                                     <td><?php echo $row["it_name"] ; ?></td>
                                        <td><?php echo number_format($initial) ; ?> </td>
                                         <td><?php echo number_format($recieved) ; ?> </td>
                                         <td><?php echo number_format($out); ?></td>
                                         <td><?php echo number_format($balance); ?></td>
                                         <td><?php echo number_format($unit_price); ?></td>
                                         <td><?php echo number_format($intem_total); ?></td>
                                        </tr>
                                    
                                    <?php 
                                    $total=$total+$intem_total;
                                    endforeach;
}
                                    ?>
                                   </tbody>
                                   </tfoot>
                                    <tr>
                                        <td colspan="8"> <b>TOTAL</b> </td>
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