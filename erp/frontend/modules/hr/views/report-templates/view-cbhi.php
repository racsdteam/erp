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
        

 <table style="margin: 0 auto;"  class="table table-bordered tbl-report tbl-dc" cellspacing="0" cellpadding="0" border="1" width="80%">
   <thead>
      <tr>
          <th class="rotate text-left">S/N</th>
         <th class="rotate text-left">EMPLOYEE No.</th>
         <th  class="rotate text-left">NAMES</th>
         <th  class="rotate text-left">Partial Net</th>
         <th  class="rotate text-left">AMOUNT (Partial Net*0.5/100)</th> 
         
        
         
      </tr>
   </thead>
 <tbody>       
  <?php foreach( $rows as $row): $i++;?> 
                <tr class="rpt-row"> 
                <td><?= $i?></td>
                 <td class="data-cell" nowrap> <?=$row['emp_no']?></td>
             
                 <td class="data-cell" nowrap> <?=$row['names']?></td>
                
                 <td class="data-cell" nowrap> <?php $totBase+=$row['cbhi_basis'] ; echo number_format($row['cbhi_basis']);?></td>
                 <td class="data-cell" nowrap> <?php $totEE+=round($row['cbhi']) ; echo number_format($row['cbhi']);?></td>
                 
                 
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr>
<th colspan="3" class="total text-left">TOTAL</th>   
<th class="total text-left"><?=number_format($totBase)?></th> 
<th class="total text-left"><?=number_format($totEE)?></th> 
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

 
     
     
