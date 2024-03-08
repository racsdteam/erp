<?php
use yii\helpers\Url;
use  common\models\User;
use common\components\ConstantsComponent;
use frontend\modules\hr\models\EmploymentType;
?>

<?php

$userID=Yii::$app->user->identity->user_id;   
$roleID=Yii::$app->user->identity->user_level;

$leave=Yii::$app->leave;
$emplTypes=EmploymentType::find()->all();
$empService=Yii::$app->empUtil;
$unitService=Yii::$app->unit;
$payroll=Yii::$app->prlUtil;

//-----------pie data--------------------------------------------------
$empTypeCount=array();
$empTypeLabels=array();


$data=array();
$labels=array();
$dataArray=array();


foreach($emplTypes as $type){
  if(($count=$empService->getEmpCountByEmplType($type->code))>0){
     
     $empTypeCount[$type->code]=$count;
     $empTypeLabels[$type->code]=$type->name;
     $dataArray[]=[$type->name,floatval($count)];
     
 }

}



?>


   
<!-- Info cardes -->
<div class="row">
     
     
   
   <?php if($row7['position_code']=='MD' ) :?>
     
     <div class="col-md-3 col-sm-6 col-xs-12">
      
      <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$leave->pending($userID,true) ?></h3>

              <p>Pending Leave Request(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['leave-approval-task-instances/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
      </div> 
     
     <?php else:  ?>
      
     
      <div class="col-md-3 col-sm-6 col-xs-12">
      
      <div class="small-box bg-danger">
            <div class="inner">
              <h3><?=$leave->drafting($userID,false) ?></h3>

              <p>Draft Leave Request(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-paper-airplane"></i>
            </div>
            <div class="d-flex justify-content-between  small-box-footer pl-2 pr-2">
              <a  href="<?=Url::to(['leave-request/create'])?>" class="btn btn-xs btn-success"><i class="fas fa-plus-circle"></i> New Request  </a>   
                 <a href="<?=Url::to(['leave-request/draft'])?>" class="text-white small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a> 
            </div>
          
          </div>
      </div>
      
    
   
    <div class="col-md-3 col-sm-6 col-xs-12">
      
      <div class="small-box bg-warning">
            <div class="inner">
              <h3><?=$leave->pending($userID,true) ?></h3>

              <p>Pending Leave Request(s) Approvals</p>
            </div>
            <div class="icon">
              <i class="ion ion-paper-airplane"></i>
            </div>
           <a class="small-box-footer" href="<?=Url::to(['leave-approval-task-instances/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
      </div> 
   
   
          
            <div class="col-md-3 col-sm-6 col-xs-12">
          
   <div class="small-box bg-info">
            <div class="inner">
              <h3><?=$payroll->pending($userID,true)?></h3>

              <p>Pending Payroll Approvals</p>
            </div>
            <div class="icon">
              <i class="ion ion-calculator"></i>
            </div>
           <a class="small-box-footer" href="<?=Url::to(['payroll-approval-task-instances/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
                
                </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
      
      <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$leave->approved($userID,true)?></h3>

              <p>Approved Leave Request(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-checkmark-circled"></i>
            </div>
           <a class="small-box-footer" href="<?=Url::to(['leave-request/approved'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
      </div>
               
                
          <?php endif;  ?>
   
   
    
       </div>
       
       <div class="row">
           
       <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="card card-success">
             
              <div class="card-body ">
               <div id="chart-contrct-status" class="chart-responsive" style="height: 350px;" ></div>   
              
              </div>
              <!-- /.card-body -->
            </div>
             </div> 
             
             <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="card card-success">
             
              <div class="card-body ">
               <div id="chart-emp-dep-unit" class="chart-responsive" style="height: 350px;" ></div>   
              
              </div>
              <!-- /.card-body -->
            </div>
             </div> 
           
       </div>
  
  <?php
         

foreach($empTypeCount as $key=>$count){
  $data[]=$count;  
}
foreach($empTypeLabels as $key=>$name){
  $labels[]=$name;
 
}


$rootedOutUnits=$unitService->getRootedOutUnits();
$categories=array();
foreach($rootedOutUnits as $u){
 
 $categories[]=$u->unit_name;   
    
}

$empCount=array();
 foreach($rootedOutUnits as $mu){
    
    $empCount[]=intVal($unitService->getEmpCount($mu->id));  
            
        }

//['#f56954 red', '#00a65a g', '#f39c12 or', '#00c0ef info', '#3c8dbc prim', '#d2d6de sec'],
$colors=array('#00a65a','#3c8dbc','#f39c12','#f56954',   '#00c0ef','#d2d6de');

$encodedData=json_encode($data); 
$encodedLabels=json_encode($labels); 
$encodedColors=json_encode($colors);
$encodeDataArr=json_encode($dataArray);
$encodedCateg=json_encode($categories);
$encodedEmpCout=json_encode($empCount); 
 


$script = <<< JS


$(document).ready(function()
                            {
    
   
  //---------------------------------counts by contact status-------------------------------
  
      chart= {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        },
        
        margin: [30, 0, 0, 10],
                           spacingTop: 0,
                           spacingBottom: 0,
                           spacingLeft: 0,
                           spacingRight: 0,
    };
    
    
    title={
        text: 'Employees Count by Appointment  Types'
    };
    
    
    accessibility= {
        point: {
            valueSuffix: '%'
        }
    };
    
    tooltip= {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    };
    
    credits= {
    enabled: false
  };
  navigation = {
                           buttonOptions: {
                               enabled: false
                           }

                       };
    plotOptions={
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
             size: '80%',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}%</b>: {point.percentage:.1f} %'
            }
        }
    };
    series= [{
        type: 'pie',
        name: 'Appointment  Type',
        data:$encodeDataArr
    }];
    
     var json = {};   
            json.chart = chart; 
            json.title = title;     
            json.tooltip = tooltip;
            json.credits = credits;
            json.series = series;
            json.plotOptions = plotOptions;
            json.navigation=navigation;
            $('#chart-contrct-status').highcharts(json);
            
            
            
 

//---------------Employees Count By Organizational Units---------------------------------------------

    chart1= {
        type: 'column',
        inverted: true
    };
    title1= {
        text: 'Employees Count By Department / Unit '
    };
   
    xAxis1= {
          allowDecimals: false,
        categories:$encodedCateg,
        crosshair: true
    };
    
    yAxis1= {
        allowDecimals: false,
        min: 0,
        title: {
            text: 'Employees'
        }
    };
    
 legend = {   enabled: false,
           layout: 'horizontal'
           
        };
    tooltip1= {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Employee(s)</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    };
    plotOptions1={
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    };
    series1= [{
         colorByPoint: true,
        data: $encodedEmpCout,
      //showInLegend: false,
     
    }];
    
    var json1 = {};   
            json1.chart = chart1;
            json1.legend =  legend;
            json1.title = title1;
            json1.xAxis =  xAxis1;
            json1.yAxis =  yAxis1;
            json1.tooltip = tooltip1;
            json1.credits = credits;
            json1.series = series1;
            json1.plotOptions = plotOptions1;
            json1.navigation=navigation;
            $('#chart-emp-dep-unit').highcharts(json1);
            

   
 });

 

    
JS;
$this->registerJs($script,$this::POS_END);

?>
