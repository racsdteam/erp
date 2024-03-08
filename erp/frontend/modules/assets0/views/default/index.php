<?php
use yii\helpers\Url;
use  common\models\User;
use frontend\modules\assets0\models\Assets;
use frontend\modules\assets0\models\AssetTypes;
?>

<?php

$userID=Yii::$app->user->identity->user_id;   
$roleID=Yii::$app->user->identity->user_level;

$util=Yii::$app->assetUtil;
$assetTypes=AssetTypes::find()->all();

//-----------pie data--------------------------------------------------
$assetTypeCount=array();
$assetTypeLabels=array();


$data=array();
$labels=array();
$dataArray=array();


foreach($assetTypes as $type){
  if(($count=$util->assetCountByType($type->code))>0){
     
     $assetTypeCount[$type->code]=$count;
     $assetTypeLabels[$type->code]=$type->name;
     
     $dataArray[]=[$type->name,floatval($count)];
     
 }

}



?>


   
<!-- Info cardes -->
<div class="row">
 
    <?php foreach(AssetTypes::find()->all() as $type) :?>
      
       
     
      <div class="col-md-3 col-sm-6 col-xs-12">
      
     
      <div class="small-box " style="background:<?php echo $type->color?> !important">
            <div class="inner">
              <h3><?=$util->countByType($type->code) ?></h3>

              <p><?php echo $type->name?></p>
            </div>
            <div class="icon">
              <i class="ion ion-paper-airplane"></i>
            </div>
            <div class="d-flex justify-content-between  small-box-footer pl-2 pr-2">
              <a  href="<?=Url::to(['assets/create','type'=>$type->code])?>" class="btn btn-xs btn-success"><i class="fas fa-plus-circle"></i> Add New   </a>   
                 <a href="<?=Url::to(['assets/index'])?>" class="text-white small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a> 
            </div>
          
          </div>
      </div>
      
    
    <?php endforeach?> 
 
      
      </div>
               
                
        
   
   
    
       </div>
       
       <div class="row">
           
       <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="card card-success">
             
              <div class="card-body ">
               <div id="chart-assets-by-status" class="chart-responsive" style="height: 350px;" ></div>   
              
              </div>
              <!-- /.card-body -->
            </div>
             </div> 
             
             <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="card card-success">
             
              <div class="card-body ">
               <div id="chart-assets-by-condition" class="chart-responsive" style="height: 350px;" ></div>   
              
              </div>
              <!-- /.card-body -->
            </div>
             </div> 
           
       </div>
  
  <?php
/*         

foreach($assetTypeCount as $key=>$count){
  $data[]=$count;  
}
foreach($assetTypeLabels as $key=>$name){
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
 
*/

$script = <<< JS



$(document).ready(function()
                            {
    
   $('#chart-assets-by-status').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Assets Type by Operational Status'
    },
    xAxis: {
        categories: ['In Service', 'In Storage', 'In Repair', 'Disposed', 'Absolute']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Goals'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    series: [{
        name: 'Desktop',
        data: [4, 4, 6, 15, 12]
    }, {
        name: 'Laptop',
        data: [5, 3, 12, 6, 11]
    }, {
        name: 'Server',
        data: [5, 15, 8, 5, 8]
    },{
        name: 'printer',
        data: [5, 15, 5, 3, 9]
    }]
})

  
$('#chart-assets-by-condition').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Assets Type by Physical Condition'
    },
    xAxis: {
        categories: ['Execellent', 'Good', 'Fair', 'Poor', 'Scraped']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Goals'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    series: [{
        name: 'Desktop',
        data: [4, 4, 6, 15, 12]
    }, {
        name: 'Laptop',
        data: [5, 3, 12, 6, 11]
    }, {
        name: 'Server',
        data: [5, 15, 8, 5, 8]
    },{
        name: 'printer',
        data: [5, 15, 5, 3, 9]
    }]
})
   
 });

 

    
JS;
$this->registerJs($script);

?>

   
 