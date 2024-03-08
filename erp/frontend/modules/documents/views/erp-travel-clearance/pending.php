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
                      <i class="fa fa-cart-arrow-down"></i><span> Pending Travel clearance </span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree11" class="panel-collapse collapse in">
                    <div class="box-body">

       <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
  
   <?php endif; ?>
  <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
  
   <?php endif; ?>
       
       <?php 
$q50 ="select t.*,r.is_new from erp_travel_clearance as t inner join erp_travel_clearance_flow as f on t.id=f.travel_clearance
 inner join erp_travel_clearance_flow_recipients as r on f.id= r.flow_id  where r.recipient=".Yii::$app->user->identity->user_id." and r.is_forwarded=0"	;
$command50 = Yii::$app->db->createCommand($q50);
$rows50= $command50->queryAll(); 

      
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
                                        <th>view and Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
 <?php $i=0;
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
                                              Url::to(["erp-travel-clearance/view-pdf",'id'=>$row5['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update','title'=>'Update person travel clearance Info' ] ); ?> </td>
                                           
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


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
  $('.action-update').click(function () {



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