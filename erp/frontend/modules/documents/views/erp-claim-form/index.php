<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Claim Forms';
$this->params['breadcrumbs'][] = $this->title;

 $q=" SELECT * FROM erp_claim_form ";
 $com = Yii::$app->db->createCommand($q);
$rows = $com->queryAll();


?>
<div class="erp-claim-form-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Erp Claim Form', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree11">
                      <i class="fa fa-cart-arrow-down"></i><span> All Claim form</span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree11" class="panel-collapse collapse in">
                    <div class="box-body">

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>N0</th>
                                        <th>Name </th>
                                        <th>Title</th>
                                        <th>Destination</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                         <th>Amount</th>
                                         <th>Status</th>
                                           <th>Created Time</th>
                                           <th>View and Action</th>
                                         <th>Doc Work Flow</th>  
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
 <?php $i=0;
 foreach($rows as $row):
$q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['person']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

 $i++;   
 if(!empty($row['tavel_clearance']))
{
 $q9=" SELECT * FROM erp_travel_clearance where id='".$row['tavel_clearance']."' ";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne(); 
$Destination=$row9['Destination'];
$particulars="Allowance";
$from=$row9['departure_date'];
$to=$row9['return_date'];
}else{
 $q9=" SELECT * FROM  erp_claim_form_details where claim_form='".$row['id']."' ";
$command9= Yii::$app->db->createCommand($q9);
$row9 = $command9->queryOne(); 
$Destination=$row9['country'];
$particulars=$row9['pariculars'];
$from=$row9['from'];
$to=$row9['to'];
}
                                  
                                  ?>
                                   
                                   
                                     <tr>
                                         <td>
                                     <?php echo  $i; ?>
                 
                                     </td>
                                     <td>
                                     <?php echo $row7["first_name"].' '.$row7["last_name"] ; ?>
                 
                                     </td>
                                     <td><?php echo $row7["position"] ; ?></td>
                                      <td>
                                            <?php echo  $Destination; ?>
                                        
                                        </td>
                                            
                                            
                                            <td><?php 
                                             
                                               echo  $from;  
                                            ?>
                                        </td>
                                        
                                         <td><?php echo $to ; ?></td>
                                          <td><?php echo $row["total_amount"]." ".$row["currancy_type"] ; ?></td>
                                           <td>
                                           <?php
                                           $status= $row["status"];
                                             if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='drafting'){
                                                  $class="label pull-left bg-graw";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;" class="'.$class.'">'.$status.'</small>'; ?></td>
                               
                                          <td><?php echo $row["timestamp"] ; ?></td> 
                                          
                                             <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                             Url::to(["erp-claim-form/view-pdf",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update','title'=>'Update person travel clearance Info' ] ); ?> </td>

                                          
                                           <td> 
                                                 <?=Html::a('<i class="fa fa-recycle"></i>',
                                             Url::to(["erp-claim-form/doc-tracking",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update','title'=>'View Claim Form Info work flow' ] ); ?> </td>  
                                            
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
     
$('.update-action').on('click',function () {


var disabled=$(this).attr('disabled');

if(disabled){
    
swal("You are not Allowed to Edit This Memo!", "", "error");
return false;
}


});  
JS;
$this->registerJs($script);
?>
