<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\bootstrap4\ActiveForm;
use common\helpers\UnitePriceHelper;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Items;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fuel History';
$this->params['breadcrumbs'][] = $this->title;

//--------------------all Items------------------------------------------------
$itemrec=Items::find()->where(['it_code'=>'OT-OT-010'])->one();
$item=$itemrec->it_id;
if(!empty($sdate)&& !empty($edate) &&!empty($item) )
{
    
$q=" SELECT rec.item_qty as qty, gr.reception_date as time, 'Received' as stock_status , rec.id as trans_id FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item
inner join reception_goods as gr on gr.id=rec.reception_good  where rec.status='approved' and rec.item=".$item." and  gr.reception_date between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   rec.timestamp ";
$com= Yii::$app->db1->createCommand($q);
$rows1 = $com->queryall();
  
$q=" SELECT  req.out_qty as qty, req.timestamp as time, 'Requested' as stock_status  , req.id as trans_id  FROM   items_request  as req   inner join items   as i  on i.it_id=req.it_id  
inner join fuel_voucher_info   as f  on f.item_request_id=req.id
where req.status='approved'  and req.it_id=".$item." and (f.date between '".$sdate."' and '".$edate."')    order by  req.timestamp ";
$com= Yii::$app->db1->createCommand($q);
$rows = $com->queryall();
$data=array_merge($rows1,$rows);


 function compare_time($a, $b)
  {
    return strnatcmp($a['time'], $b['time']);
  }

  // sort alphabetically by name
  usort($data, 'compare_time');
$qty_in=0;
$qty_out=0;
  $q4=" SELECT sum(rec.item_qty) as 'tot' FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item
inner join reception_goods as gr on gr.id=rec.reception_good where rec.status='approved' and rec.item=".$item." and  gr.reception_date<'".$sdate."' ";
  $command4 = Yii::$app->db1->createCommand($q4);
  $row4= $command4->queryOne();
  $qty_in=$row4['tot'];
 $q4=" SELECT sum(req.out_qty ) as 'tot'  FROM   items_request  as req   inner join items   as i  on i.it_id=req.it_id  
inner join fuel_voucher_info   as f  on f.item_request_id=req.id where req.status='approved'  and req.it_id=".$item." and f.date < '".$sdate."' ";
 $command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_out=$row4['tot'];

$qty_remaining=$qty_in-$qty_out;


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
 <h3 class="card-title"><i class="fa fa-tag"></i><?= $itemrec->it_name." with code ".$itemrec->it_code ?> History Report  from <?= $sdate ?> to <?= $edate ?></h3>
  <title><?= $itemrec->it_name." with code ".$itemrec->it_code ?> History Report  from <?= $sdate ?> to <?= $sedate ?></title>
<?php
}else{
?>
 <h3 class="card-title"><i class="fa fa-tag"></i>The  Stock Fuel History Report  </h3>
  <title>The  Stock Fuel History Report </title>
<?php
}
?>
 </div>
 <div class="card-body">
<h4>Fuel History Form</h4>
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
       
 <div class="col-xs-3">
        
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
      
 <div class="col-xs-3">
        
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
                                       <th>Date</th>
                                        <th>Car</th>
                                          <th>Trans.Type</th>
                                        <th>Initial Qty</th>
                                        <th>New Qty</th>
                                        <th>Remaining Qty</th>
                                         <th>Unite Price</th>
                                        <th>Trans. Total Price</th>
                                      
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php
                                  if(!empty($data)):
                                  $i=0;
                                  $initial=$qty_remaining;
                                  $balance=0;
                                  foreach($data as $row):
                                   $i++;
                                   
                                    $your_date = strtotime($row['time']);
                                    $edate2 = date("Y-m-d", $your_date);
                                     $unit_price=UnitePriceHelper::Calculate($item,$sdate,$edate);
                                  //   var_dump($edate2);die();
  if($unit_price==0)
{
                                            $q4=" SELECT i.*  FROM  items_reception as i  inner join reception_goods as rec on i.reception_good=rec.id  where 	i.item='".$item."' 
                                            and i.status='approved'  order by i.timestamp desc";
                             $command4 = Yii::$app->db1->createCommand($q4);
                            $row4= $command4->queryOne();
                                   $total_price=$row4['total_price'];
                                   $item_qty=$row4['item_qty'];
                                   $unit_price=$total_price/$item_qty;
}
                                    if($row['stock_status']=='Received')
                                    {
                                        $qty=$row['qty'];
                                        $car="N-A";
                                         $date=$row['time']; 
                                    }else{
                                        $qty=-$row['qty'];
                                        $q5=" SELECT *  FROM  fuel_voucher_info   where 	item_request_id='".$row['trans_id']."'";
                             $command5 = Yii::$app->db1->createCommand($q5);
                            $row5= $command5->queryOne();  
                                       $car=$row5['car']; 
                                       $date=$row5['date']; 
                                         
                                    }
                                    $balance=$initial+$qty;
                                     
                                     
                                     $item_total=$row['qty']*(int)$unit_price;
            
                                  ?>
                                   
                                   
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                      <td><?php echo $date; ?> </td>
                                       <td><?php echo $car; ?> </td>
                                      <td><?php echo $row['stock_status']; ?> </td>  
                                     <td>  <?php echo $initial." ".$item_record['it_unit'] ; ?></td>
                                     <td><?php echo $qty." ".$item_record['it_unit']; ?></td>
                                      <td><?php echo $balance." ".$item_record['it_unit'] ; ?> </td>
                                          <td><?php echo number_format($unit_price); ?> RwFrs</td>
                                         <td><?php echo number_format($item_total); ?> RwFrs</td>
                                         
                                        </tr>
                                    
                                    <?php 
                                   $initial=$balance;
                                     if($row['stock_status']=='Received')
                                    {
                                   $total_r=$total_r+$item_total;
                                    }
                                    else{
                                     $total_u=$total_u+$item_total;   
                                    }
                                    endforeach;
                                    endif;
                                    ?>

                                    </tbody>
                                         </tfoot>
                                    <tr>
                                        <td colspan="7"> <b>TOTAL Received</b> </td>
                                         <td colspan="2"> <b><?= number_format($total_r) ?> RwFrs </b> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"> <b>TOTAL Used</b> </td>
                                         <td colspan="2"> <b><?= number_format($total_u) ?> RwFrs </b> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"> <b>TOTAL Balance</b> </td>
                                         <td colspan="2"> <b><?= number_format($total_r-$total_u) ?> RwFrs </b> </td>
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

     $(".select2").select2({width:'100%',theme: 'bootstrap4'});
 });
JS;
$this->registerJs($script);

?>