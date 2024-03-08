<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =$model->description;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

    .dataTable th {
  word-wrap: break-word;
}
 .dataTable tr td, .dataTable tr th {
  border: 1px solid #dee2e6;
  vertical-align: bottom;
  
}



th.rotate {
  height: 200px;
  padding: 5px;
  font-weight: bold;
  font-family:sans-serif;
  font-size:16px;
 
}
th.rotate > div {
  writing-mode: vertical-rl;
  transform: rotate(-180deg);
}
.textH {
  height: 200px;
 
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-folder-open"></i> <?=$model->description?></h3>
                       </div>
               
           <div class="card-body">

     <div class="table-responsive">
    <table id="tbl-detail-view"   class="table table-custom table-head-fixed  dataTable "  cellspacing="0" width="100%">
   <thead>
      <tr>
         
         <th class="rotate"><div><div class="textH">Employee No.</div> </div></th>
         <th class="rotate"><div><div class="textH">Company Reg. Number</div> </div></th>
         <th class="rotate"><div><div class="textH">Declared Period</div> </div></th>
         <th class="rotate"><div><div class="textH">Type Declared</div> </div></th>
         <th class="rotate"><div><div class="textH">RSSB Employee No</div></div></th>
         <th class="rotate"><div><div class="textH"> Medical Employee No</div> </div></th>
         <th class="rotate"><div><div class="textH">Employee First Name</div></div></th>
         <th class="rotate"><div><div class="textH">Employee Last Name</div> </div></th>
         <th class="rotate"><div><div class="textH">Basic Salary</div></div></th>
         <th class="rotate"><div><div class="textH"> Employee Contrib. (7.5%)</div> </div></th>
         <th class="rotate"><div><div class="textH"> Employer Contrib. (7.5%)</div> </div></th> 
         <th class="rotate"><div><div class="textH"> Total (15%)</div> </div></th> 
         <th class="rotate"><div><div class="textH"> Starting Date</div> </div></th> 
         <th class="rotate"><div><div class="textH"> Ending Date</div> </div></th> 
         
        
         
      </tr>
   </thead>
 <tbody>
               <?php foreach( $rows as $row):  ?> 
               <?php 
               $tot=0;
               $ee=filter_var($row['ee_amount'], FILTER_SANITIZE_NUMBER_INT); 
               $ec=filter_var($row['ec_amount'], FILTER_SANITIZE_NUMBER_INT);
               $tot=$ee+$ec;
               $period_start=date('d/m/Y', strtotime($row['pay_period_start']));
               $period_end=date('d/m/Y', strtotime($row['pay_period_end']));
               $basic_tot+=filter_var($row['earnings_basis'], FILTER_SANITIZE_NUMBER_INT); 
               $ec_tot+=filter_var($row['ec_amount'], FILTER_SANITIZE_NUMBER_INT);
               $ee_tot+=filter_var($row['ee_amount'], FILTER_SANITIZE_NUMBER_INT); 
               $ec_ee_tot+=filter_var($tot, FILTER_SANITIZE_NUMBER_INT); 
               $net_tot=0;
               ?>     
                    <tr>
                
                    <td><?= $row['employee_no']?></td>   
                    <td><?=12?></td>
                     <td><?= $period_start?></td>
                     <td><?= $row['declaration_type']?></td>
                     <td><?=$row['ssn_num']?></td>
                     <td><?=$row['med_num']?></td>
                     <td><?=$row['first_name']?></td>
                     <td><?=$row['last_name']?></td>
                      <td><?=$row['earnings_basis']?></td>
                    <td><?=$row['ee_amount']?></td>
                    <td><?=$row['ec_amount']?></td>   
                   <td><?=number_format($tot)?>
                   </td>    
                   <td><?= $period_start ?></td>
                    <td><?= $period_end ?></td>
                     
                      </tr>
                    
                   
                    
                      <?php endforeach ?>    
               
                    </tbody>
                     <tfoot>
<tr><th class="text-left" colspan="8">TOTAL</th><th><?=number_format($basic_tot)?></th>
<th><?php echo number_format($ec_tot);?></th>
<th><?php echo number_format($ee_tot);?></th>
<th><?php echo number_format($ec_ee_tot);?></th>
<th></th>
<th></th>
</tr>
</tfoot>
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
});

JS;
$this->registerJs($script);

?>



