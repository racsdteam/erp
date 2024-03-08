
<h3 style="text-align:center">
    <b><?php echo $model->description; ?></b> <br>
        <b>BK: 00040-0281597-39</b>

</h3>

 <table    class="contentTable "  cellspacing="0" width="100%">
   <thead>
      <tr text-rotate="180">
         
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
<tr class="text-left"><th colspan="8">TOTAL</th><th><?=number_format($basic_tot)?></th>
<th ><?php echo number_format($ec_tot);?></th>
<th><?php echo number_format($ee_tot);?></th>
<th><?php echo number_format($ec_ee_tot);?></th>
<th></th>
<th></th>
</tr>
</tfoot>
</table>

       

 
     
     
