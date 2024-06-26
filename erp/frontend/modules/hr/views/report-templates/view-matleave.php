<?php
use frontend\modules\hr\models\PayrollApprovalRequests;
?>
 
     
    <h3 style="text-align:center"><?php echo $model->rpt_desc; ?></h3>
          <?php 
   
         $totBase=0;
         $totEE=0;
         $totER=0;
         $tot=0;
         $i=0;
         $approval_request=PayrollApprovalRequests::findOneContainsReport($model->id);
        ?>
  <div class="table-responsive">         
 <table  class="table table-bordered tbl-report" cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
      <tr>
          <th>SN</th>
          <th class="rotate text-left"><div><div class="textH">Company Reg.Number</div> </div></th>
           <th class="rotate text-left"><div><div class="textH">Declared Period</div> </div></th>
            <th class="rotate text-left"><div><div class="textH">Type Declared</div> </div></th>
             <th class="rotate text-left"><div><div class="textH"> RSSB Employee No</div> </div></th>
             <th class="rotate text-left"><div><div class="textH"> ID Number</div> </div></th>
                <th class="rotate text-left"><div><div class="textH">Emp No.</div> </div></th>
               <th class="rotate text-left"><div><div class="textH"> Employee First Name</div> </div></th>
                 <th class="rotate text-left"><div><div class="textH"> Employee Last Name</div> </div></th>
                   <th class="rotate text-left"><div><div class="textH"> D.O.B</div> </div></th>
                <th class="rotate text-left"><div><div class="textH">Declaration Base (Amount)</div> </div></th>
               <th class="rotate text-left"><div><div class="textH">RSSB (Maternity Leave Employee Contribution) 0.3%</div> </div></th>
               <th class="rotate text-left"><div><div class="textH"> RSSB (Maternity Leave Employer Contribution) 0.3%  </div> </div></th>
               <th class="rotate text-left"><div><div class="textH"> Total Maternity leave (0.6%)</div> </div></th>
                <th class="rotate text-left"><div><div class="textH"> Starting Date</div> </div></th>
               <th class="rotate text-left"><div><div class="textH"> Ending Date</div> </div></th>
     
      </tr>
   </thead>
 <tbody>       
 
 <?php foreach( $rows as $row): $i++;?> 
                <tr class="rpt-row"> 
                <td><?= $i?></td>
                 <td class="data-cell" nowrap> <?=$row['comp_pension_no']?></td>
                 <td class="data-cell" nowrap> <?=formatDate($row['declared_period'])?></td>
                 <td class="data-cell" nowrap> <?=$row['type_delcared']?></td>
                 <td class="data-cell" nowrap> <?=$row['rssb_emp_no']?></td>
                 <td class="data-cell" nowrap> <?=$row['nid']?></td>
                 <td class="data-cell" nowrap> <?=$row['emp_no']?></td>
                 <td class="data-cell" nowrap> <?=$row['first_name']?></td>
                 <td class="data-cell" nowrap> <?=$row['last_name']?></td>
                    <td class="data-cell" nowrap> <?=$row['dob']?></td>
                 <td class="data-cell" nowrap> <?php $totBase+=$row['pension_basis'] ; echo number_format($row['pension_basis']);?></td>
                 <td class="data-cell" nowrap> <?php $totEE+=($ee=round($row['RSSBMLEE'])) ; echo number_format($ee);?></td>
                 <td class="data-cell" nowrap>  <?php $totER+=($er=round($row['RSSBMLER'])) ; echo number_format($er);?></td>
                 <td class="data-cell" nowrap> <?php  $tot+=($tot_ee=$ee+$er) ; echo number_format($tot_ee);?></td>
                 <td class="data-cell" nowrap> <?=formatDate($row['starting_date'])?></td>
                 <td class="data-cell" nowrap> <?=formatDate($row['ending_date'])?></td>   
                 
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr>
<th colspan="10" class="text-left">TOTAL</th>   
<th class="total text-left"><?=number_format($totBase)?></th> 
<th class="total text-left"><?=number_format($totEE)?></th> 
<th class="total text-left"><?=number_format($totER)?></th> 
<th class="total text-left"><?=number_format($tot)?></th> 
<th colspan="2"></th>
</tr>
</tfoot>
</table>
</div>
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


function formatDate($dateStr){
    
  return  date('d/m/Y', strtotime($dateStr));
}

?>

 
     
     
