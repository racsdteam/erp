<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Welcome to Logistics Dashboard';


if(empty($year))
{
$year=date('Y');
}
$sdate=$year."-01-01";
$edate=$year."-12-31";
$q4=" SELECT sum(rec.item_qty) as 'tot' FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item    
where i.it_sub_categ='Consummable'  and rec.status='approved'
and  rec.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   rec.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_in_Consummable=$row4['tot'];
if(empty($qty_in_Consummable))
{
    $qty_in_Consummable=0;
}
$q4=" SELECT sum(out_qty) as 'tot' FROM  items_request  as req   inner join items   as i  on i.it_id=req.it_id  
where 	i.it_sub_categ='Consummable'  and req.status='approved' and  req.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   req.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_out_Consummable=$row4['tot'];
if(empty($qty_out_Consummable))
{
    $qty_out_Consummable=0;
}
$current_Consummable= $qty_in_Consummable-$qty_out_Consummable;


$q4=" SELECT sum(rec.item_qty) as 'tot' FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item    
where i.it_sub_categ='Equipment'  and rec.status='approved'
and  rec.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   rec.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_in_Equipment=$row4['tot'];
if(empty($qty_in_Equipment))
{
    $qty_in_Equipment=0;
}
$q4=" SELECT sum(out_qty) as 'tot' FROM  items_request  as req   inner join items   as i  on i.it_id=req.it_id  
where 	i.it_sub_categ='Equipment'  and req.status='approved' and  req.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   req.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_out_Equipment=$row4['tot'];
if(empty($qty_out_Equipment))
{
    $qty_out_Equipment=0;
}
$current_Equipment= $qty_in_Equipment-$qty_out_Equipment;


$q4=" SELECT sum(rec.item_qty) as 'tot' FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item    
where i.it_sub_categ='Fuel'  and rec.status='approved'
and  rec.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   rec.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_in_Fuel=$row4['tot'];
if(empty($qty_in_Fuel))
{
    $qty_in_Fuel=0;
}
$q4=" SELECT sum(out_qty) as 'tot' FROM  items_request  as req   inner join items   as i  on i.it_id=req.it_id  
where 	i.it_sub_categ='Fuel'  and req.status='approved' and  req.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   req.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_out_Fuel=$row4['tot'];
if(empty($qty_out_Fuel))
{
    $qty_out_Fuel=0;
}
$current_Fuel= $qty_in_Fuel-$qty_out_Fuel;

$q4=" SELECT sum(rec.item_qty) as 'tot' FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item    
where i.it_sub_categ='Asset'  and rec.status='approved'
and  rec.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   rec.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_in_Asset=$row4['tot'];
if(empty($qty_in_Asset))
{
    $qty_in_Asset=0;
}
$q4=" SELECT sum(out_qty) as 'tot' FROM  items_request  as req   inner join items   as i  on i.it_id=req.it_id  
where 	i.it_sub_categ='Asset'  and req.status='approved' and  req.timestamp between '".$sdate." 00:00:00' and '".$edate." 23:59:59'  order by   req.timestamp ";
$command4 = Yii::$app->db1->createCommand($q4);
$row4= $command4->queryOne();
$qty_out_Asset=$row4['tot'];
if(empty($qty_out_Asset))
{
    $qty_out_Asset=0;
}
$current_Asset= $qty_in_Asset-$qty_out_Asset;




for ($i=1 ;$i <= 12;$i++)
{
$q23=" SELECT sum(rec.item_qty) as 'tot' FROM  items_reception as rec   inner join items   as i  on i.it_id=rec.item    
where   rec.status='approved' and  rec.timestamp  between  '".$year."-".$i."-01 00:00:00'  and '".$year."-".$i."-31 23:59:59'  order by rec.timestamp desc";

$com23 = Yii::$app->db1->createCommand($q23);
$r23 = $com23->queryone(); 

$q24="SELECT sum(out_qty) as 'tot' FROM  items_request  as req   inner join items   as i  on i.it_id=req.it_id  
where req.status='approved' and  req.timestamp between  '".$year."-".$i."-01 00:00:00'  and '".$year."-".$i."-31 23:59:59'   order by req.timestamp desc ";
$com24 = Yii::$app->db1->createCommand($q24);
$r24 = $com24->queryone(); 
$serie[]= floatval($r23['tot']);
$serie2[]= floatval($r24['tot']);
}

$months=json_encode(array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
));

$serie=json_encode($serie);
$serie2=json_encode($serie2);

  $i=2019;
                    $year2=date("Y");
                    while($i<=$year2)
                    {
                    $years[$year2] = $year2;  
                    $year2--;
                    }

?>

		<style type="text/css">
.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 800px;
    margin: 1em auto;
}
#container {
      min-height:700px;
}
#container1 {
      height: 700px;

}	
.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>
      <div class="row">
          <div class="col-md-12">
          <div class="card card-default color-palette-card">
 <div class="card-header with-border">
     
  <h4>Filter by year</h4>
   </div>
 <div class="card-body">
     
  <div class="row">
      
   
          
         <?php
  $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data','class'=>'form-inline '],
                                'id'=>'dynamic-form', 
                                //'class'=>'form-inline',
                               'enableClientValidation'=>true,
                              
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); 

?>
     

         
              <div class="form-group mx-sm-4 ">       
             
                <?=
$form->field($searchModel, 'year' )
     ->dropDownList($years,[ 'style' => 'width:300px !important', ])->label("sellect year:") ; ?> 
               
            </div>  

 <?= Html::submitButton($model->isNewRecord ?'<i class="fa fa-search"></i> Filter':'<i class="fa   fa-edit "></i> search', 
 ['class' =>'btn btn-primary btn btn-success']) ?>   

	<?php ActiveForm::end(); ?>   
          
      
    
      
  </div>       
         

	
    </div>
    </div>
    </div>
    </div>

<!-- Info cardes -->
<div class="row">
<div class="col-md-10 offset-md-1 col-ms-12 col-xs-12">
    
<div class="card card-default color-palette-card">
 <div class="card-header with-border">
      <h3 class="card-title">Stock Quantities  from  <?= $year ?></h3
      </div>
 <div class="card-body">
          <figure class="highcharts-figure">
    <div id="container"></div>
        </div>
        </figure>
</div>
    </div>
</div>
</div>
<?php
$script = <<< JS
var serie= $serie;
var serie2= $serie2;
var months= $months;

$(document).ready(function()
		{
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});
            	$('.datetime').bootstrapMaterialDatePicker
			({
				time: true,
				clearButton: true,
				format: 'YYYY-MM-DD HH:MM'
			});
			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

	});
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Historical graph for Quantity of items delivered to stock and the ones Out of Stock'
    },
    subtitle: {
        text: 'Source: RAC ERP System'
    },
    xAxis: {
        categories: months,
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Stock Quantities on annual base',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'normal',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },
 tooltip: {
        valueSuffix: ' Units'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
   
    credits: {
        enabled: false
    },
    series:[{name:"Received Items",
            data:   serie},
            {name:"Out Stock Items",
            data:   serie2},
            ]
});
JS;
$this->registerJs($script);

?>