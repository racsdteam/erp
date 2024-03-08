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

$this->title = 'Item History';
$this->params['breadcrumbs'][] = $this->title;

//--------------------all Items------------------------------------------------
$items=ArrayHelper::map(Items::find()->all(), 'it_id',function($item){
    return  $item->it_code.' / '.$item->it_name.' / '.$item->it_unit;
}) ;

if(!empty($sdate)&& !empty($edate) &&!empty($item) )
{
    
$q=" SELECT i.* FROM  items   as i  where it_id=".$item." ";
$com= Yii::$app->db1->createCommand($q);
$item_record = $com->queryOne();    

$q=" SELECT rec.item_qty as qty, gr.reception_date as time,gr.end_user_officer as user, 'Received' as stock_status FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item
inner join reception_goods as gr on gr.id=rec.reception_good  where rec.status='approved' and rec.item=".$item." and rec.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   rec.timestamp ";
$com= Yii::$app->db1->createCommand($q);
$rows1 = $com->queryall();
  
$q=" SELECT  req.out_qty as qty, req.timestamp as time, req.user as user, 'Requested' as stock_status FROM   items_request  as req   inner join items   as i  on i.it_id=req.it_id
where req.out_status=1  and req.it_id=".$item." and (req.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59')    order by  req.timestamp ";
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
  $q4=" SELECT sum(item_qty) as 'tot' FROM  items_reception   where 	item='".$item."'  and status='approved' and timestamp<= '".$sdate." 00:00:00' ";
  $command4 = Yii::$app->db1->createCommand($q4);
  $row4= $command4->queryOne();
  $qty_in=$row4['tot'];
 $q4=" SELECT sum(out_qty) as 'tot' FROM   items_request   where 		it_id='".$item."'  and out_status=1 and timestamp<= '".$sdate." 00:00:00' ";
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
 <h3 class="card-title"><i class="fa fa-tag"></i><?= $item_record['it_name']." with code ".$item_record['it_code'] ?> History Report  from <?= $sdate ?> to <?= $edate ?></h3>
  <title><?= $item_record['it_name']." with code ".$item_record['it_code'] ?> History Report  from <?= $sdate ?> to <?= $sedate ?></title>
<?php
}else{
?>
 <h3 class="card-title"><i class="fa fa-tag"></i>The  Stock Item History Report  </h3>
  <title>The  Stock Item History Report </title>
<?php
}
?>
 </div>
 <div class="card-body">
<h4>Item History Form</h4>
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
       
             
   <div class="col-md-6 col-xs-6">
        
       
              <label> Item  </label>
                      <?= Html::dropDownList("item",null ,$items,['prompt'=>'Select type...','class'=>[' select2'],
                      
                      'options' =>

                    [                        

                      $item => ['selected' => true]

                    ]

          ]

                      )?>
               
                <!-- /.input group -->
               </div> 
 
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
                                           <th>User </th>
                                        <th>Department</th>
                                       <th>Date</th>
                                          <th>Trans.Type</th>
                                        <th>Initial Qty</th>
                                        <th>New Qty</th>
                                        <th>Remaining Qty</th>
                                         <th>Unite_Price RwFrs</th>
                                        <th>Trans_Total_Price RwFrs</th>
                                      
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
                                    $edate = date("Y-m-d", $your_date);
                                     $unit_price=UnitePriceHelper::Calculate($item,$sdate,$edate);
  if($unit_price==0)
{
                                            $q4=" SELECT *  FROM  items_reception   where 	item='".$item."' 
                                            and status='approved' and timestamp < '".$sdate." 00:00:00' order by timestamp desc";
                             $command4 = Yii::$app->db1->createCommand($q4);
                            $row4= $command4->queryOne();
                                   $total_price=$row4['total_price'];
                                   $item_qty=$row4['item_qty'];
                                   if($item_qty > 0)
                                   $unit_price=$total_price/$item_qty;
}
                                    if($row['stock_status']=='Received')
                                    {
                                        $qty=$row['qty'];
                                    }else{
                                         $qty=-$row['qty'];
                                    }
                                    $balance=$initial+$qty;
                                     
                                     
                                     $item_total=$row['qty']*(int)$unit_price;
                                    $user=UserHelper::getUserInfo($row['user']);
                                    $unity_ifo=UserHelper::getOrgUnitInfo($row['user']);
                                  ?>
                                   
                                   
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                      <td><?= $user['first_name'] ." ".$user['last_name'] ?> </td>
                                     <td>  <?php echo $unity_ifo['unit_name']." ".$unity_ifo['unit_level'] ; ?></td>
                                      <td><?php echo $row['time']; ?> </td>
                                      <td><?php echo $row['stock_status']; ?> </td>  
                                     <td>  <?php echo $initial; ?></td>
                                     <td><?php echo $qty; ?></td>
                                      <td><?php echo $balance ; ?> </td>
                                          <td><?php echo number_format($unit_price); ?> </td>
                                         <td><?php echo number_format($item_total); ?></td>
                                         
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
                                        <td colspan="9"> <b>TOTAL Received</b> </td>
                                         <td colspan="2"> <b><?= number_format($total_r) ?> RwFrs </b> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9"> <b>TOTAL Used</b> </td>
                                         <td colspan="2"> <b><?= number_format($total_u) ?> RwFrs </b> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9"> <b>TOTAL Balance</b> </td>
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