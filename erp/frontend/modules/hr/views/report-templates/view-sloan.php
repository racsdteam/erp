<?php
use frontend\modules\hr\models\PayrollApprovalRequests;
?>
  <h3 style="text-align:center"><?php echo $model->rpt_desc; ?></h3>
          <?php 
   
         $totBase=0;
         $totEE=0;
         $tot=0;
         $i=0;
         $approval_request=PayrollApprovalRequests::findOneContainsReport($model->id);
        ?>
        

 <table  class="tbl-report" cellspacing="0" cellpadding="0" border="1" width="100%">
   <thead>
      <tr>
          <th class="text-left">S/N</th>
         <th class="text-left">EMPLOYEE No.</th>
         <th  class="text-left">NAMES</th>
         <th  class="text-left">AMOUNT</th> 
         
        
         
      </tr>
   </thead>
 <tbody>       
  <?php foreach( $rows as $row): $i++;?> 
                <tr class="rpt-row"> 
                <td><?= $i?></td>
                 <td class="data-cell" nowrap> <?=$row['emp_no']?></td>
             
                 <td class="data-cell" nowrap> <?=$row['name']?></td>
                
                 <td class="data-cell" nowrap> <?php $totEE+=$row['sloan'] ; echo number_format($row['sloan']);?></td>
                 
                 
                 </tr> 
                 
                 <?php endforeach ?> 
                 
                    </tbody>
                     <tfoot>
<tr>
<th colspan="3" class="text-left">TOTAL</th>   

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

 
     
     
