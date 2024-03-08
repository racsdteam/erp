<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpMemoAttachMerge;
use common\models\ErpMemoRequestForAction;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;


$q99=" SELECT tr.*,p.position,u.first_name,u.last_name  FROM 
 erp_travel_request as tr inner join erp_travel_clearance as tc on tc.tr_id=tr.id  inner join user as u on u.user_id=tc.employee 
  inner join erp_persons_in_position as pp  on pp.person_id=u.user_id
 inner join erp_org_positions as p  on p.id=pp.position_id
 where tc.id='".$model->id."'";
 $com99 = Yii::$app->db->createCommand($q99);
 $rows99 = $com99->queryOne();




?>
<style>


</style>
<table  style="width:100%;"  cellspacing="0" cellpadding="0">
                                   
 <tr>
<td align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
<td style="padding:20 0px" align="right"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>

</tr> 
</table>


<h2 align="center"><b><u>TRAVEL CLEARANCE</u></b></h2>
<br>



<table  style="width:100%;"  cellspacing="0" cellpadding="0">
                                    
                                
                                    
                                        <tr>
                                        <td width="35%" height="30"  align="left">TO Mr., Mss., Mrs. : </td>
                                      
                                        <td height="30"><?= $rows99["first_name"]." ".$rows99["last_name"]  ?></td>
                                       </tr>
                                       <tr>
                                        <td height="30" width="35%"  align="left">TITLE : </td>
                                      
                                        <td height="30"><?= $rows99["position"] ?></td>
                                       </tr>
                                       <tr>
                                        <td height="30" width="35%" align="left">PURPOSE OF THE MISSION : </td>
                                      
                                        <td height="30"><?= $rows99["purpose"] ?></td>
                                       </tr>
                                        <tr>
                                        <td height="30" width="35%" align="left">DESTINATION : </td>
                                      
                                        <td height="30"><?= $rows99["destination"] ?></td>
                                       </tr>
                                       <tr>
                                        <td height="30" width="35%" align="left">MEANS OF TRANSPORT : </td>
                                      
                                        <td height="30"><?= $rows99["means_of_transport"] ?></td>
                                       </tr>
                                        
                                        <tr>
                                        <td height="30" width="35%" align="left">DATE OF DEPARTURE : </td>
                                      
                                        <td height="30" ><?= $rows99["departure_date"]  ?></td>
                                       </tr>
                                        <tr>
                                        <td height="30" width="35%" align="left">RETURN : </td>
                                      
                                        <td height="30"><?= $rows99["return_date"]  ?></td>
                                       </tr>
                                        <tr>
                                        <td height="30" width="35%" align="left">TRAVEL EXPENSES : </td>
                                      
                                        <td height="30"><?= $rows99["tr_expenses"]  ?></td>
                                       </tr>
                                        
                                      </table>
                                       
                                       
                                       <table  style="width:100%;"  cellspacing="0" cellpadding="0" >
                                           
                                         
                                        <tr>
                                        <td  height="50" width="18%" align="left">DIRECTOR UNIT</td>
                                      
                                        <td style="background: url('img/dot.gif') 0 66% repeat-x; color:black;font-size:20px;" width="52%" height="50"></td>
                                        
                                        <td width="30%"></td>
                                       </tr>
                                       
                                       </table>
                                       
                    
                                       <table>
                                       
                                       <?php 
                                     
                                       if($rows99['created']<"2019-09-24")
                                       {
                                         
                                       ?>
                                       <tr>
                                        <td height="30" width="40%" align="left">AG. HEAD HUMAN RESOURCES</td>
                                      
                                        <td style="width:45%; background: url('img/dot.gif') 0 68% repeat-x; color:black;font-size:20px;" height="30"></td>
                                         
                                         <td></td>
                                       </tr>
                                       <?php 
                                       }else{
                                       ?>
                                       <tr>
                                        <td height="30" width="40%" align="left">Director HUMAN RESOURCES</td>
                                      
                                        <td style="width:45%; background: url('img/dot.gif') 0 68% repeat-x; color:black;font-size:20px;" height="30"></td>
                                         
                                         <td></td>
                                       </tr>
                                       <?php } ?>
                                       </table>
                                       
                                       <table>
                                       
                                       <tr>
                                        <td height="30" width="35%" align="left">ISSUED AT KIGALI, ON </td>
                                      
                                        <td style="width:30%; background: url('img/dot.gif') 0 68% repeat-x; color:black;font-size:20px;" height="30"></td>
                                        
                                        <td></td>
                                      
                                       </tr>
                                       
                                       </table>
                                       
                                       
                                       <table>
                                       
                                       <tr>
                                           <td  colspan=2>
                                             <?php 
                                     
                                       if($rows99['created']<"2020-07-17")
                                       {
                                         
                                       ?>  
                                             <b>Firmin KARAMBIZI</b><br>
                                        <?php
                                       }else{
                                       ?>
                                        <b>Charles HABOMNIMANA</b><br>
                                       <?php
                                       }
                                       ?>
                                             
                                             <b>Managing Director</b><br>
                                             <b>Rwanda Airports Company</b><br><br>
                                             DATE OF ARRIVAL: <br>
                                             <hr>
                                             DATE OF DEPARTURE:
                                             <hr>
                                             DATE OF ARRIVAL:
                                              <hr>
                                              <p>
                                                  
                                             <b> COMMENTS (IF NECESSARY)</b> <br>
                                            SIGNATURE & STAMP OF THE SUPERVISOR<br>
                                               (WHERE THE MISSION WAS CARRIED OUT)
    
                                                  
                                              </p>
                                           </td>
				 
                                       </tr>    
                                           
                                           
                                       </table>
                                       
                                      
                                       
                                  
                                                                   
       
                                                                    
                                                                 


   

