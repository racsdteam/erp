<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\bootstrap4\ActiveForm;
use common\helpers\UnitePriceHelper;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Items;
use common\models\UserHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distributed Stock';
$this->params['breadcrumbs'][] = $this->title;



if(!empty($sdate)&& !empty($edate))
{

$itemrec=Items::find()->where(['it_code'=>'OT-OT-010'])->one();
$item=$itemrec->it_id;

$q=" SELECT * FROM   items_request as req where req.it_id<>".$item." and req.out_status=1 and req.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   req.timestamp desc ";
$com= Yii::$app->db1->createCommand($q);
$rows = $com->queryall();
//var_dump($rows); die();
}
?>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
<?php
if(!empty($sdate)&& !empty($edate) && !empty($item) )
{
?>
 <h3 class="card-title"><i class="fa fa-tag"></i>Distributed Item History Report  from <?= $sdate ?> to <?= $edate ?></h3>
  <title>Distributed Item History Report  from <?= $sdate ?> to <?= $sedate ?></title>
<?php
}else{
?>
 <h3 class="card-title"><i class="fa fa-tag"></i>Distributed Item History Report  </h3>
  <title>Distributed Item History Report </title>
<?php
}
?>
 </div>
 <div class="card-body">
<h4>Distributed Report Form</h4>
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
              <label> Starting Date </label>
                  <input class="form-control date "  placeholder="starting date" name="sdate"  value=<?php if(!empty($sdate))  echo $sdate; ?>>
               
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
              <label>Ending Date </label>
                  <input class="form-control date "  placeholder="ending date" name="edate"  value=<?php if(!empty($edate))  echo $edate; ?>>
               
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
                                           <th>Requested_By</th>
                                        <th>Department</th>
                                           <th>Date</th>
                                      <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Initial Qty</th>
                                         <th>Requested Qty</th>
                                         <th>Total Qty</th>
                                        <th>Unite_Price RwFrs</th>
                                        <th>Total_Price RwFrs</th>
                                         
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  <?php
                                  if(!empty($rows)):
                                  $i=0;
                                  
                                  $total=0;
                                  foreach($rows as $row):
                                   $i++;
                                   
                                   $q=" SELECT i.* FROM  items   as i  where it_id=".$row['it_id']." ";
                                   $com= Yii::$app->db1->createCommand($q);
                                    $item_record = $com->queryOne();
                                    
$qty_in=0;
$qty_out=0;
 $balance=0;
  $q4=" SELECT sum(item_qty) as 'tot' FROM  items_reception   where  item='".$row['it_id']."'  and status='approved' and timestamp< '".$row['timestamp']."' ";
  $command4 = Yii::$app->db1->createCommand($q4);
  $row4= $command4->queryOne();
  $qty_in=$row4['tot'];
 $q4=" SELECT sum(out_qty) as 'tot' FROM   items_request   where it_id='".$row['it_id']."'  and out_status=1 and timestamp< '".$row['timestamp']."' ";
 $command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_out=$row4['tot'];

$qty_remaining=$qty_in-$qty_out;
$initial=$qty_remaining;                                    
                                    
                                    $balance=$initial+$row['item_qty'];
                                     
                                     $your_date = strtotime($row['timestamp']);
                                    $edate2 = date("Y-m-d", $your_date);
                                      $unit_price=UnitePriceHelper::Calculate($row['it_id'],$sdate,$edate2);
                                     // var_dump($edate2);die();
                                      if($unit_price==0)
                                      {
                                            $q4=" SELECT *  FROM  items_reception   where 	item='".$row['it_id']."' 
                                            and status='approved'  order by timestamp desc";
                             $command4 = Yii::$app->db1->createCommand($q4);
                            $row4= $command4->queryOne();
                                   $total_price=$row4['total_price'];
                                   $item_qty=$row4['item_qty'];
                                   $unit_price=$total_price/$item_qty;
                                      }
                                      $total_item=(int)$unit_price*$row['out_qty'];
                                      $total_item_vat=($total_item*118)/100;
                                      
                                     $user=UserHelper::getUserInfo($row['user']);
                                    $unity_ifo=UserHelper::getOrgUnitInfo($row['user']);
                                    //  var_dump($unity_ifo); die();
                                    
                                    
                                    $your_date = strtotime($row['timestamp']);
                                    $date = date("Y-m-d", $your_date);
                                    ?>
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                      <td><?= $user['first_name'] ." ".$user['last_name'] ?> </td>
                                     <td>  <?php echo $unity_ifo['unit_name']." ".$unity_ifo['unit_level'] ; ?></td>
                                      <td><?php echo $date; ?> </td>
                                     <td>  <?php echo $item_record['it_code'] ; ?></td>
                                     <td><?php echo $item_record['it_name']; ?></td>
                                      <td><?php echo $initial; ?> </td>
                                        <td><?php echo $row['out_qty'] ; ?> </td>
                                        <td><?php echo $balance ; ?> </td>
                                         <td><?php echo number_format($unit_price); ?> </td>
                                          <td><?php echo number_format($total_item); ?></td>
                                          
                                        </tr>
                                    
                                    <?php 
                                    $total=$total+$total_item;
                                    
                                    endforeach;
                                    endif;
                                    ?>
      
                                    </tbody>
                                      </tfoot>
                                    <tr>
                                        <td colspan="10"> <b>TOTAL</b> </td>
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
				 $(function () {
   
      $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
    
 });
JS;
$this->registerJs($script);

?>