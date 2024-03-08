<?php
use frontend\modules\hr\models\PayrollApprovalRequests;
?>
     
    <h3 style="text-align:center"><?php echo $model->rpt_desc; ?></h3>
          <?php 
        
        
         $totGross=0;
         $totPaye=0;
          $approval_request=PayrollApprovalRequests::findOneContainsReport($model->id);
          $i=0;
         
        ?>
    
 <table style="margin: 0 auto;" class="table table-bordered tbl-report  tbl-dc" cellspacing="0" cellpadding="0" border="1" width="80%">
   <thead>
      <tr>
             <th class="rotate text-left"><div><div class="textH">SN.</div> </div></th>
          <th class="rotate text-left"><div><div class="textH">Emp No.</div> </div></th>
       <th class="rotate text-left"><div><div class="textH">Name</div> </div></th>
       <th class="rotate text-left"><div><div class="textH">Gross Pay</div> </div></th>
       <th class="rotate text-left"><div><div class="textH">TPR/PAYE</div> </div></th>
      </tr>
   </thead>
 <tbody>       
 
 <?php foreach( $rows as $row): $i++?> 
                <tr class="rpt-row"> 
                 <td class="data-cell" nowrap> <?=$i?></td>
                 <td class="data-cell" nowrap> <?=$row['emp_no']?></td>
                 <td class="data-cell" nowrap> <?=$row['Name']?></td>
                 <td class="data-cell" nowrap> <?php $totGross+=$row['paye_basis'] ; echo number_format($row['paye_basis'])?></td> 
                 <td class="data-cell" nowrap> <?php $totPaye+=round($row['PAYE']) ; echo number_format($row['PAYE'])?></td>
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr class="text-left">
<th colspan="3" class="text-left text-bold">TOTAL</th>   
<th  class="total text-left text-bold"><?=number_format($totGross)?></th> 
<th  class="total text-left text-bold"><?=number_format($totPaye)?></th> 

</tr>
</tfoot>
</table>

<div style="margin: 20px;padding:10px;">
     <p style="margin-bottom:30px;text-align:left">Done at Kigali, on <?= date("d/m/Y",strtotime($model->timestamp)) ?></p>
    <p style="margin-bottom:10px;text-align:left">Prepared by:    HR Payroll Officer…………………</p>
<?php if(!empty($approval_request) && !empty($approval_request->getWfInstance())) : ?>

<?=$this->render('/report-templates/_approval',['model'=>$model,'wf'=>$approval_request->getWfInstance()]) ?>
<?php endif;?>
</div> 
<?php

function array_flatten( $arr, $out=array() )  {
	foreach( $arr as $item ) {
		if ( is_array( $item ) ) {
			$out = array_merge( $out,  $item  );
		} else {
			$out[] = $item;
		}
	}
	return $out;
}


?>

 
     
     
