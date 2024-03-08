<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\Employees;
use yii\bootstrap\ActiveForm;
use frontend\modules\hr\models\PayGroups;
use NXP\MathExecutor;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payroll List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>
<style>


.tbl-report th {
  word-wrap: break-word;
}
.tbl-report th{
     white-space: pre-line;
 }

 .tbl-report tr td, .tbl-report tr th {
  border: 1px solid #dee2e6;
  vertical-align: bottom;
  
}

.tbl-report th.rotate {
  height: 200px;
 font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif; 
 font-size: 16px; 
 font-style: normal; 
 font-variant: normal; 
 font-weight: 700;
  
  
 
}

th.rotate > div {
  writing-mode: vertical-rl;
  transform: rotate(-180deg);
 
 color:#000000;
}

th.editable > div{
    
   padding-left:30px;
}

.tbl-preview-sum td, .tbl-preview-sum th, .tbl-report td, .tbl-report th {
   padding: .20rem !important;
    
    
}  
.tbl-report tbody{
    
 font-family: Helvetica , Geneva, sans-serif;
 font-size: 14px;
 font-style: normal;
 font-variant: normal; 
 font-weight: 400;

}


</style>

      
      <?php
      $rows=$model->payrollData();
     
      
      $totals=[];
      $colsTotals=[];
      $colsBold=[];
      
     
      
      $payTmpl=$model->payGroup0->payTemplate;
      $cols=$payTmpl->lineItems;
      $editables=[];
      foreach($cols as $col){
          if($col->calc_type=='open'){
             
              $editables[$col->id]=$col;
          }
      }
      
      foreach($cols as $col){
          if(in_array($col->category,['BASE','G','N'])){
             
               $colsBold[$col->id]=$col;
             
          }
          
          $totals[$col->payItem->code]=0;
      }
     
      $showPosition=($model->pay_period_year > 2022 && intVal($model->pay_period_month) >=6); 
       $i=0;
      
      ?>
   <div class="invoice p-3 mb-3">
    <h3 style="text-align:center"><?php echo $model->name; ?></h3>           
              
   <?php if($model->status=='draft') :?>
    <div class="d-flex  flex-sm-row flex-column  justify-content-end mb-3">
      <div class="btn  bg-gradient-warning btn-flat  btn-refresh">
                    <i class="fas fa-sync"></i> Refresh   
                        
                    </div>
                    
      <div class="btn  bg-gradient-info btn-flat  btn-finilise">
                    <i class="fas fa-thumbs-up"></i> Finalise Payroll    
                        <?php  
                          
$form = ActiveForm::begin([
    'id' => 'payroll-finilise-form',
    'action'=>['payrolls/finilise'],
    'options' => ['class' => 'form-horizontal'],
]) ?>
  <?= Html::hiddenInput('id', $model->id);?>
  <?php ActiveForm::end() ?> 
                        
                    </div>
 
                   
</div>
  <?php endif;?>
                   <div class="table-responsive">
    <table   class="table  tbl-report compact "  cellspacing="0" width="100%">
   <thead>
      <tr>
          <th  class="rotate"><div><div class="textH">SN</div> </div></th>
          <th  class="rotate"><div><div class="textH">Employee No.</div> </div></th>
         <th class="rotate"><div><div class="textH">Employee Name</div> </div></th>
         <?php if ($model->pay_period_year > 2022 && intVal($model->pay_period_month) >=6 ):?>
         <th class="rotate"><div><div class="textH">Employee Position</div> </div></th>
         <?php endif;?>
         <?php foreach( $cols as $key=>$col)  : ?>
        
         <th class="rotate <?php echo isset($editables[$col->id]) && $model->status!='completed'?'editable':''; echo isset($colsBold[$col->id]) ?'strong':''; ?>"  
         <?php  echo isset($editables[$col->id]) && $model->status!='completed' ? "data-col=".$col->id.' '." data-item=".$col->item : '';?>>
             <div><div class="textH"><?php echo $col->payItem->name ?></div> </div></th>
       
          <?php endforeach;?>
      </tr>
   </thead>
<tbody>
<?php foreach($rows as $row): $i++?>
<tr>
<td nowrap><?= $i ?></td>
<td nowrap><?= $row["employee_no"] ?></td>
<td nowrap><?= $row["full_name"] ?></td>
<?php if ($model->pay_period_year > 2022 && intVal($model->pay_period_month) >=6 ):?>
<td nowrap><?= $row["position"] ?></td>
<?php endif;?>
<?php foreach( $cols as $key=>$col)  : ?>
    
<td><?=number_format($row[$col->payItem->code]) ?></td>
  <?php 
  $totals[$col->payItem->code] =round($row[$col->payItem->code])+$totals[$col->payItem->code] ?> 
<?php endforeach;?>
</tr>
<?php endforeach ?>
    
                    </tbody>
                    
                     <tfoot>
                         <tr>
                               <th colspan="<?php echo $showPosition?4:3?>">G.TOTAL</th>
                               
                               
                          <?php foreach( $cols as $key=>$col)  :?>
                          <th><?php //if($col->payItem->code=='N' && in_array($model->pay_group,['RSCIV']))
                            //$totals[$col->payItem->code]=$totals[$col->payItem->code]-36;    
                          echo number_format($totals[$col->payItem->code]) ?></th>
                          <?php endforeach ?>
                       
</tr>
</tfoot>
                 
</table>
</div>

 </div>
  


<?php

function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}
?>

<?php

$script = <<< JS

 $(document).ready(function(){


var table = $('.tbl-report').DataTable({
      destroy:true,
      lengthChange: true,
      pageLength: 50,
      info: true,
      ordering: false,
      autoWidth: false,
    
      /*columnDefs: [{
        targets: 'sort',
        orderable: true
      }],*/
   dom: '<"row"<"col-sm-4"B><"col-sm-4" l><"col-sm-4"f>>'+
       '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
       '<"row"<"col-sm-5"i><"col-sm-7"p>>',
      fixedHeader: {
        header: false
      },
     
      buttons: {
        buttons: [{
          extend: 'print',
          text: '<i class="fas fa-print"></i> Print',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true,
          autoPrint: true,
           customize: function(win)
            {
 
                var last = null;
                var current = null;
                var bod = [];
 
                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');
 
                style.type = 'text/css';
                style.media = 'print';
 
                if (style.styleSheet)
                {
                  style.styleSheet.cssText = css;
                }
                else
                {
                  style.appendChild(win.document.createTextNode(css));
                }
 
                head.appendChild(style);
         }
          
        }, {
          extend: 'pdf',
          text: '<i class="far fa-file-pdf"></i> PDF',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        ,{
          extend: 'excel',
          text: '<i class="far fa-file-excel"></i> Excel',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        
        
        ],
        
        
        dom: {
          container: {
            className: 'dt-buttons'
          },
          button: {
            className: 'btn btn-default dt-button'
          }
        }
      }
    });	
});

JS;
$this->registerJs($script);

?>





