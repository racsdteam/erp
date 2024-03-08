<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Passenger Manifests';
$this->params['breadcrumbs'][] = $this->title;
  $q2 = new Query;
if(!empty($airline)&&!empty($date)&&!empty($number))
{

$q2->select([
    'p.*'
    
])->from('passenger_manifest as p')->where(['p.Operating_carrier_designator' =>$airline,'p.flight_number' =>$number])->limit(5000); 
$q2->andWhere(['like', 'p.date_of_flight', $date]);
}
else{
 
$q2->select([
    'p.*'
    
])->from('passenger_manifest as p')->orderBy(['p.recorded' => SORT_DESC])->limit(5000);
}
$command2 = $q2->createCommand();
$rows2= $command2->queryAll();



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
              <label> Flight Date of Departure </label>
                  <input class="form-control date "  placeholder="Flight date" name="date"  value=<?php if(!empty($date))  echo $date; ?>>
               
                </div>
                  </div>   
                <!-- /.input group -->
               </div> 
      </div>
<div class="form-group">
    
 <?= Html::submitButton($model->isNewRecord ?'<i class="fa fa-search"></i> Search':'<i class="fa   fa-edit "></i> Update', 
 ['class' =>'btn btn-primary btn btn-success']) ?>   
</div>
   

<?php ActiveForm::end(); ?>
  
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                           <th>N0</th>  
                                       <th>Passenger Name</th>
                                        <th>Flight Number</th>
                                        <th>Date Of Flight</th>
                                        <th>Seat Number</th>
                                        <th>Passenger Status</th>
                                        <th>From City Airport Code</th>
                                        <th>To City Airport Code</th>
                                        <th>Passenger Description</th>
                                         <th>Operating Carrier Pnr Code</th>
                                        <th>Created at</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php
                                  
                                  $i=0;
                                  foreach($rows2 as $row2):
                                   $i++;
                                  ?>
                                   
                                   
                                     <tr>
                                     <td><?php echo  $i ; ?></td>
                                     <td><?php echo $row2["passenger_fn"] ; ?> <?php echo $row2["passenger_ln"] ; ?></td>
                                     <td><?php echo $row2["Operating_carrier_designator"] ; ?> <?php echo $row2["flight_number"] ; ?></td>
                                      <td><?php echo $row2["date_of_flight"] ; ?> </td>
                                       <td><?php echo $row2["seat_number"] ; ?> </td>
                                        <td><?php echo $row2["passenger_status"] ; ?> </td>
                                         <td><?php echo $row2["from_city_airport_code"] ; ?> </td>
                                          <td><?php echo $row2["to_city_airport_code"] ; ?> </td>
                                           <td><?php echo $row2["passenger_description"] ; ?> </td>
                                            <td><?php echo $row2["operating_carrier_pnr_code"] ; ?> </td>
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