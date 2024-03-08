<?php
use frontend\modules\hr\models\PayrollApprovalRequests;
?>
 
     
    <h3 style="text-align:center"><?php echo $model->rpt_desc; ?></h3>
          <?php 
         $mmiPayable=array_flatten(json_decode($rows[0]['mmi_payable'],true));
         $mmiPayableCodes=array_keys($mmiPayable);
         $mmiPayableItems=\frontend\modules\hr\models\PayItems::findAllByCode($mmiPayableCodes);
         
         $totPayable=array();
         $totGross=0;
         $totEE=0;
         $totER=0;
         $tot=0;
         $approval_request=PayrollApprovalRequests::findOneContainsReport($model->id);
         $i=0;
        ?>
 <div class="table-responsive">     
 <table  class="table table-bordered tbl-report" cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
      <tr> <th class="rotate text-left"><div><div class="textH">SN</div> </div></th>
           <th class="rotate text-left"><div><div class="textH">Emp No.</div> </div></th>
       <th class="rotate text-left"><div><div class="textH">Name</div> </div></th>
      <?php
      
      foreach($mmiPayableItems as $key=>$item) :$totPayable[$item->code]=0;?>
       <th  class="rotate text-left"><div><div class="textH"><?=$item->name?></div> </div></th>
      <?php endforeach ?>
      
       <th class="rotate text-left"><div><div class="textH">Gross</div> </div></th>
       <th class="rotate text-left"><div><div class="textH">MMI Employee Contrib.(3% of Gross Salary)</div> </div></th>
        <th class="rotate text-left"><div><div class="textH">MMI Employer Contrib.(17.5% of Gross Salary)</div> </div></th>
        <th class="rotate text-left"><div><div class="textH"> Total (20.5%)</div> </div></th>
      </tr>
   </thead>
 <tbody>       
 
 <?php foreach( $rows as $row): $rowPayable=array_flatten(json_decode($row['mmi_payable'],true)); $i++;?> 
                <tr class="rpt-row">
                     <td class="data-cell" nowrap> <?=$i;?></td> 
                     <td class="data-cell" nowrap> <?=$row['emp_no']?></td> 
                 <td class="data-cell" nowrap> <?=$row['name']?></td>
                 
                 <?php foreach($mmiPayableItems as $key=>$item) : $totPayable[$item->code]+=$rowPayable[$item->code] ?> 
                    
                 <td class="data-cell" nowrap> <?=number_format($rowPayable[$item->code])?></td>
                      
                    
                    <?php endforeach ?> 
                  
                      
                 <td class="data-cell" nowrap> <?php $totGross+=$row['mmi_basis'] ; echo number_format($row['mmi_basis'])?></td> 
                 <td class="data-cell" nowrap> <?php $totEE+=($ee=round($row['mmiee'])) ; echo number_format($row['mmiee'])?></td>
                 <td class="data-cell" nowrap> <?php $totER+=($er=round($row['mmier'])) ; echo number_format($row['mmier'])?></td>
                 <td class="data-cell" nowrap> <?php $tot+=($line_tot=$ee+$er) ; echo number_format($line_tot)?></td>
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr>
<th  colspan="3" class="text-left">TOTAL</th>   
<?php foreach($mmiPayableItems as $key=>$item) :?>
      <th class="total text-left"><?=number_format($totPayable[$item->code])?></th>
<?php endforeach;?>
<th class="total text-left"><?=number_format($totGross)?></th> 
<th class="total text-left"><?=number_format($totEE)?></th> 
<th class="total text-left"><?=number_format($totER)?></th> 
<th class="total text-left"><?=number_format($tot)?></th>
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


?>

 
     
     
