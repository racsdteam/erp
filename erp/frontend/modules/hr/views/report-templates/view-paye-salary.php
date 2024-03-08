<?php
use frontend\modules\hr\models\PayrollApprovalRequests;
?>
     
    <h3 style="text-align:center"><?php echo $model->rpt_desc; ?></h3>
          <?php 
        
         $taxable=array_flatten(json_decode($rows[0]['taxable'],true));
         $taxableCodes=array_keys($taxable);
         $taxableItems=\frontend\modules\hr\models\PayItems::findAllByCode($taxableCodes);
         $totTaxable=array();
         $totGross=0;
         $totPaye=0;
         $approval_request=PayrollApprovalRequests::findOneContainsReport($model->id);
         $i=0;
        ?>
        
 <table  class="table table-bordered tbl-report tbl-dc" cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
      <tr>
           <th class="rotate text-left"><div><div class="textH">SN.</div> </div></th> 
          <th class="rotate text-left"><div><div class="textH">Emp No.</div> </div></th>  
       <th class="rotate text-left"><div><div class="textH">Name</div> </div></th>
      <?php
      
      foreach($taxableItems as $key=>$item) :$totTaxable[$item->code]=0;?>
       <th  class="rotate text-left"><div><div class="textH"><?=$item->name?></div> </div></th>
      <?php endforeach ?>
      
       <th class="rotate text-left"><div><div class="textH">Gross</div> </div></th>
       <th class="rotate text-left"><div><div class="textH">PAYE/TPR</div> </div></th>
      </tr>
   </thead>
 <tbody>       
 
 <?php foreach( $rows as $row): $rowTaxable=array_flatten(json_decode($row['taxable'],true));$i++?> 
                <tr class="rpt-row">
                  <td class="data-cell" nowrap> <?=$i?></td> 
                 <td class="data-cell" nowrap> <?=$row['emp_no']?></td> 
                 <td class="data-cell" nowrap> <?=$row['Name']?></td>
                 
                 <?php foreach($taxableItems as $key=>$item) : $totTaxable[$item->code]+=$rowTaxable[$item->code] ?> 
                    
                 <td class="data-cell" nowrap> <?=number_format($rowTaxable[$item->code])?></td>
                      
                    
                    <?php endforeach ?> 
                  
                      
                 <td class="data-cell" nowrap> <?php $totGross+=$row['paye_basis'] ; echo number_format($row['paye_basis'])?></td> 
                 <td class="data-cell" nowrap> <?php $totPaye+=round($row['PAYE']) ; echo number_format($row['PAYE'])?></td>
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr>
<th colspan="3" class="text-left">TOTAL</th>   
<?php foreach($taxableItems as $key=>$item) :?>
         <th class="total text-left" ><?=number_format($totTaxable[$item->code])?></th>
         <?php endforeach;?>
<th class="total text-left"><?=number_format($totGross)?></th> 
<th class="total text-left"><?=number_format($totPaye)?></th> 

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

 
     
     
