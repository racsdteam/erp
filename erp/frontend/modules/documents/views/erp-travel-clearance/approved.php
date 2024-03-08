<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


</style>
<div class="erp-travel-clearance-index">

    <h1><?= Html::encode($this->title) ?></h1>
   <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree11">
                      <i class="fa fa-cart-arrow-down"></i><span> Approved Travel clearance </span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree11" class="panel-collapse collapse in">
                    <div class="box-body">

       
       
       <?php
    $q10=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command01 = Yii::$app->db->createCommand($q10);
    $r_MD = $command01->queryOne();       

   //------------------------------------------Approved Travel Clearances--------------------------------------------------------------

if(!empty( $r_MD)){
  $q50=" SELECT t.*,t.id as tr_id,t_ap.*,t_ap.id as app_id FROM erp_travel_clearance_approval as t_ap inner join erp_travel_clearance  as t  on t.id=t_ap.travel_clearance where
 t_ap.approval_status='approved' and t_ap.approved_by={$r_MD['person_id']} ";
 $com50 = Yii::$app->db->createCommand($q50);
 $rows50= $com50->queryAll(); 
}   
       ?>
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>N0</th>
                                        <th>Name </th>
                                        <th>Title</th>
                                        <th>Destination</th>
                                        <th>Departure Date</th>
                                         <th>Status</th>
                                           <th>Created Time</th>
                                        <th>view</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
 <?php
 $i=0;
 if(!empty($rows50))
 {
 foreach($rows50 as $row5):
 $q99=" SELECT p.position,u.first_name,u.last_name  FROM  user as u  
  inner join erp_persons_in_position as pp  on pp.person_id=u.user_id
 inner join erp_org_positions as p  on p.id=pp.position_id
 where u.user_id='".$row5['employee']."'";
 $com99 = Yii::$app->db->createCommand($q99);
 $rows99 = $com99->queryOne();

 $i++;                                
 
                                  ?>
                                   
                                   
                                     <tr class=" <?php if($row5['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                         <td>
                                     <?php echo  $i; ?>
                 
                                     </td>
                                     <td>
                                     <?php echo $rows99["first_name"].' '.$rows99["last_name"] ; ?>
                 
                                     </td>
                                     <td><?php echo $rows99["position"] ; ?></td>
                                      <td>
                                            <?php echo  $row5["Destination"]; ?>
                                        
                                        </td>
                                          
                                        
                                            <td><?php 
                                             
                                               echo  $row5["departure_date"];  
                                            ?>
                                        </td>
                                        
                                 
                                           <td>
                                           <?php
                                           $status= $row5["status"];
                                             if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;" class="'.$class.'">'.$status.'</small>'; ?></td>
                               
                                          <td><?php echo $row5["created_at"] ; ?></td>  

                                             <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                             Url::to(["erp-travel-clearance/view-pdf",'id'=>$row5['tr_id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'View person travel clearance Info' ] ); ?> </td>
                                           
                                            

                                             <td> 
                                                 <?=Html::a('<i class="fa fa-plus"></i> Add claim form',
                                             Url::to(["erp-claim-form/create",'t'=>$row5['tr_id']
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-add-claim','title'=>'Add Claim Form' ] ); ?> </td> 
                                            
                                        </tr>
                                    
                                    <?php endforeach;}?>
                                    
                                   
                                        


                                    </tbody>
                                </table>
 </div>


                    </div>
                    </div>
                    </div>
</div>
 <!--modal -->           
 <div class="modal modal-info" id="modal-action">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
              <div  id="modalContent"> <div style="text-align:center"><img src="<?=Yii::$app->request->baseUrl?>/img/m-loader.gif"></div></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<?php

$script = <<< JS
  $('.action-add-claim').click(function () {



var url = $(this).attr('href');
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
 $('#modal-action .modal-title').text($(this).attr('title'));
return false;
 });
    
    
     $('.action-view').click(function () {



var url = $(this).attr('href');
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
 $('#modal-action .modal-title').text($(this).attr('title'));
return false;
 });   
JS;
$this->registerJs($script);
?>