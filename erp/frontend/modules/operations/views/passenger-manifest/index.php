<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$connection1 = \Yii::$app->db1;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Passengers Information';
$this->params['breadcrumbs'][] = $this->title;

if(!empty($airline)&&!empty($date)&&!empty($number))
{
$q2=" SELECT *  FROM passenger_manifest as p  where p.Operating_carrier_designator='".$airline."'  and p.flight_number like '%".$number."%' and (recorded between  '".$date." 00:00:00'  and '".$date." 23:59:59')  ";
$q22=" SELECT count(*) as tot FROM passenger_manifest as p  where p.Operating_carrier_designator='".$airline."'  and p.flight_number like '%".$number."%' and (recorded between   '".$date." 00:00:00'  and '".$date." 23:59:59')  ";
$q23=" SELECT count(*) as tot FROM passenger_manifest as p  where p.Operating_carrier_designator='".$airline."'  and p.flight_number like '%".$number."%' and (recorded between   '".$date." 00:00:00'  and '".$date." 23:59:59')  and  from_city_airport_code ='KGL'";
   
}
else{
 
$q2=" SELECT * FROM passenger_manifest as p order by  p.recorded  desc limit 5000";
 $q22=" SELECT count(*) as tot FROM passenger_manifest";
 $q23=" SELECT count(*) as tot FROM passenger_manifest where  from_city_airport_code ='KGL'";
}
$command2 = Yii::$app->db->createCommand($q2);
$rows2= $command2->queryAll();


 $com22 = Yii::$app->db->createCommand($q22);
       $r22 = $com22->queryall(); 


 $com23 = Yii::$app->db->createCommand($q23);
       $r23 = $com23->queryall(); 

$q22 = new Query;
$q22->select([
    'a.*'
    
])->from('`erp_airlines_operator` as a')->orderBy(['a.company_name' => SORT_ASC]);
$command22 = $q22->createCommand();
$rows22= $command22->queryAll();


?>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="box box-default color-palette-box">
 <div class="box-header with-border">
<?php
if(!empty($airline) && !empty($date) && !empty($number))
{
?>
 <h3 class="box-title"><i class="fa fa-tag"></i>boarding pass scanned for flight : <?= $airline."".$number ?> on <?= $date ?></h3>
  <title><i class="fa fa-tag"></i>boarding pass scanned for flight : <?= $airline."".$number ?> on <?= $date ?></title>
<?php
}else{
?>
    <h3 class="box-title"><i class="fa fa-tag"></i>Last 5000 boarding pass scanned</h3>
    <title><i class="fa fa-tag"></i>Last 5000 boarding pass scanned</title>
   <?php
}
?>
 </div>
 <div class="box-body">
<h4>Filter using flight information</h4>
<?php
  $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'action' => ['passenger-manifest/index'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); 

?>

      <div class="row">
       
             
 <div class="col-xs-4">
        <div class="form-group">
       <label> Airlines </label>
          <select class="form-control" name="airline" data-validation="required">
                <?php foreach($rows22 as $row22): ?> 
                <option value="<?= $row22['abreveation'] ?>" <?php if($airline==$row22['abreveation'])  echo "selected"; ?>><?= $row22['company_name']?> </option>
                 <?php endforeach;?>
          </select>
           </div>
   </div>    
    <div class="col-xs-4">
        <div class="form-group">
       <label> Flight Number: Write only numbers </label>
        <input class="form-control "  placeholder="0,1,2,3 ... 9" name="number" value=<?php if(!empty($number))  echo $number; ?>  >
           </div>
   </div>  
 <div class="col-xs-4">
        
                <div class="input-group">
                      <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                     <div class="form-group">
              <label> Checking Desk Recording Date: </label>
                  <input class="form-control date "  placeholder="Flight date" name="date"  value=<?php if(!empty($date))  echo $date; ?>>
               
                </div>
                  </div>   
                <!-- /.input group -->
               </div> 
      </div>
<div class="form-group">
    
 <?= Html::submitButton($model->isNewRecord ?'<i class="fa fa-search"></i> Filter':'<i class="fa   fa-edit "></i> Update', 
 ['class' =>'btn btn-primary btn btn-success']) ?>   
</div>

   <div class="row">
<div class="col-md-4 col-sm-6 col-xs-12">
    
        <div class="small-box bg-orange">
            <div class="inner">
              <h3><?php echo   $r22[0]['tot'] ?>BPs</h3>

              <p>Total Scanned Boanding Pass</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          </div>
          
</div>


<div class="col-md-4 col-sm-6 col-xs-12">
    
        <div class="small-box bg-green">
            <div class="inner">
              <h3><?php 
              echo   $r23[0]['tot'];?>BPs </h3>
              <p>Dep. from KGL Scanned Boanding Pass</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          </div>
          
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    
        <div class="small-box bg-teal">
            <div class="inner">
              <h3><?php 
               $other=$r22[0]['tot']-$r23[0]['tot'];
              echo   $other;?> BPs</h3>

              <p>Other Scanned Boanding Pass</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          </div>
          
</div>

</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
<?php ActiveForm::end(); ?>
  
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                           <th>N0</th>  
                                       <th>Passenger Name</th>
                                       <th>Operating Carrier</th>
                                        <th>Flight Number</th>
                                        <th>Date Of Flight</th>
                                        <th>Seat Number</th>
                                        <th>Passenger Status</th>
                                        <th>From City Airport Code</th>
                                        <th>To City Airport Code</th>
                                        <th>Passenger Description</th>
                                         <th>Operating Carrier Pnr Code</th>
                                          <th>Status</th>
                                          <th>location</th>
                                        <th>Created at</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php
                                  
                                  $i=0;
                                  foreach($rows2 as $row2):
                                     $q3=" SELECT * FROM erp_desko_location   where id='".$row2["from_location"]."'  ";
                                     $command3 = Yii::$app->db->createCommand($q3);
                                     $row3= $command3->queryOne();
                                     
                                     
                                      $q4=" SELECT * FROM erp_airlines_operator   where abreveation='".$row2["Operating_carrier_designator"]."'  ";
                                     $command4 = Yii::$app->db->createCommand($q4);
                                     $row4= $command4->queryOne();
                                   $i++;
                                  ?>
                                   
                                   
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                     <td><?php echo $row2["passenger_ln"] ; ?> <?php echo $row2["passenger_fn"] ; ?> </td>
                                     <td><?php
                                     if(!empty($row4['company_name']))
                                     {
                                           echo $row4["company_name"] ; 
                                     }else{
                                     echo $row2["Operating_carrier_designator"] ; 
                                     
                                     }
                                     ?></td>
                                     
                                     <td><?php echo $row2["flight_number"] ; ?></td>
                                      <td><?php echo $row2["date_of_flight"] ; ?> </td>
                                       <td><?php echo $row2["seat_number"] ; ?> </td>
                                        <td><?php echo $row2["passenger_status"] ; ?> </td>
                                         <td><?php echo $row2["from_city_airport_code"] ; ?> </td>
                                          <td><?php echo $row2["to_city_airport_code"] ; ?> </td>
                                           <td><?php echo $row2["passenger_description"] ; ?> </td>
                                            <td><?php echo $row2["operating_carrier_pnr_code"] ; ?> </td>
                                             <td><?php 
                                             if($row2["from_status"]=="CHKN")
                                             echo "DGIE Departure Check" ; 
                                              elseif($row2["from_status"]=="TRNST")
                                             echo "Rwandair Transit Check" ; 
                                             else
                                              echo "Boarding Check" ; 
                                             ?> </td>
                                              <td><?php echo $row3["location_name"] ; ?> </td>
                                             <td><?php echo $row2["recorded"] ; ?> </td>
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
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