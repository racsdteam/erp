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
     
<br>
<br>
<br>
<br>
<h2 align="center"><b><u>TRAVEL CLEARANCE</u></b></h2>
<br>

<p>Issued under the authority given by RAC Board of Director's Meeting Resolution of April 26<sup>th</sup>,2018</p>
<br>

<table  style="width:100%;"  cellspacing="0" cellpadding="0">
                                    
                                
                                    
                                   
                                        <tr>
                                        <th width="20%" height="50"  align="left">Name: </th>
                                      
                                        <td height="50"><?= $rows99["first_name"]." ".$rows99["last_name"]  ?></td>
                                       </tr>
                                       <tr>
                                        <th height="50" width="20%"  align="left">Title: </th>
                                      
                                        <td height="50"><?= $rows99["position"] ?></td>
                                       </tr>
                                        <tr>
                                        <th height="50" width="20%" align="left">Destination: </th>
                                      
                                        <td height="50"><?= $rows99["destination"] ?></td>
                                       </tr>
                                        <tr>
                                        <th height="50" width="20%" align="left">Reason: </th>
                                      
                                        <td height="50"><?= $rows99["purpose"] ?></td>
                                       </tr>
                                        <tr>
                                        <th height="50" width="20%" align="left">Departure date: </th>
                                      
                                        <td height="50" ><?= $rows99["departure_date"]  ?></td>
                                       </tr>
                                        <tr>
                                        <th height="50" width="20%" align="left">Return date: </th>
                                      
                                        <td height="50"><?= $rows99["return_date"]  ?></td>
                                       </tr>
                                        <tr>
                                        <th height="50" width="20%" align="left">Travel expenses: </th>
                                      
                                        <td height="50"><?= $rows99["tr_expenses"]  ?></td>
                                       </tr>
                                        <tr>
                                        <th height="50" width="20%" align="left">Flight: </th>
                                      
                                        <td height="50"><?= $rows99["flight"] ?></td>
                                       </tr>
                                  
                                                                    </table>
                                                                    
                                <div style="width:300px; margin:0 auto;margin-top:20px;">
        <table>
            
                                     <tr>
                                        <th align="left">Done at Kigali :</th>
                                      
                                        <td style="width:60%; background: url('img/dot.gif') 0 68% repeat-x; color:black;font-size:20px;"></td></td>
                                       </tr> 
                                       
                                       <tr>
                                           <td style="padding-top:55px" colspan=2>
                                               
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
                                             <b>Rwanda Airports Company</b><br>
                                           </td>
				 
				       

                                       
                                      
                                     
                                       </tr> 
        </table>
    </div>
                                                                    
                                                                 


