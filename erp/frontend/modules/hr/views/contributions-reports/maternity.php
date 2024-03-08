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
  padding: 0px;
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
                            <h3 class="card-title"><i class="fas fa-database"></i></h3>
                       </div>
               
           <div class="card-body">

     <div class="table-responsive">
    <table id="tbl-detail-view"   class="table  dataTable "  cellspacing="0" width="100%">
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
});

JS;
$this->registerJs($script);

?>



