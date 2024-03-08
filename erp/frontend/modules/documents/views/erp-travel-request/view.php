<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;
use common\models\Erprquest_idAttachMerge;
use common\models\Erprquest_idRequestForAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpTravelClearance;
use common\models\ErpTravelRequestType;
use common\models\ErpTravelRequestApproval;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title ='Travel Request';
$this->params['breadcrumbs'][] = $this->title;


?>

<style>

.myDiv{
	display:none;
} 

 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  }
  
  tr.sect,h3.sect { background-color:#3c8dbc !important;color:white;}
  
.add-action{
    
    padding:25px;
} 
p.add-action{
   
  padding:25px; 
}

</style>

<?php



?>



<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
    
               
   

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>
  
  <?php if (Yii::$app->session->hasFlash('failure')): ?>
 
<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
                <?php  echo Yii::$app->session->getFlash('failure')  ?>
              </div>


        <?php endif; ?>
  
    
         
         
                           <!----------------------------travel clearance(s) ------------------------------------------ -->

<div class="col-xs-12">
          <div class="box box-solid ">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-plane"></i> Travel Request Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
             
            </div> <!-- end header-->
          
            <div class="box-body">
           
            <?php

  
    
   
   
        $q1 = new Query;
$q1	->select([
    'tc.employee'
    
])->from('erp_travel_clearance as tc')->join( 'INNER JOIN', 
                'erp_travel_request as tr',
                'tc.tr_id =tr.id'
            )->where(['tc.tr_id' =>$model->id])	; 
   $command1 = $q1->createCommand();
   $rows1= $command1->queryAll();         
            
        
   
 
    
    $type=ErpTravelRequestType::find()->where(['id'=>$model->type])->One();
     $config=[
         
        [
        'group'=>true,
        'label'=>'SECTION 1: Travel Information',
        'rowOptions'=>['class'=>'sect ']
    ],
   
   //-----------------col1----------------------- 
    [
        
        'columns' => [
                [
                    
                    'label'=>'Travel Type',
                     'format'=>'raw',
                    'value'=>'<small style="padding:10px;border-radius:13px;" class="label pull-left bg-blue">'.$type->type.'</small>',
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    //'labelColOptions'=>['style'=>'width:10%'] 
                ],
                [
                    
                    'label'=>'Purpose',
                    'value'=>$model->purpose,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                   // 'labelColOptions'=>['style'=>'width:10%'] 
                ],
                
               
               
            ], 
        
        ],
         
     //---------------------------col2--------------------------------     
       
       [
           
           
           'columns'=>[
          
           [
                    
                    'label'=>'Destination',
                    'value'=>$model->destination,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    //'labelColOptions'=>['style'=>'width:10%'] 
                ],
           [
                    'attribute'=>'means_of_transport',
                    'label'=>'Mode of Transport',
                    'value'=>$model->means_of_transport,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    // 'labelColOptions'=>['style'=>'width:10%'] 
                ],
          
          ]  
           
           
           
           ],
   //-------------------------------col3-------------------------------------
   
   [
       
       'columns'=>[
                
                 [
                    'attribute'=>'departure_date',
                    'label'=>'Departure Date',
                    'value'=>$model->departure_date,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    // 'labelColOptions'=>['style'=>'width:10%'] 
                ],
                [
                    'attribute'=>'return_date',
                    'label'=>'Return Date',
                    'value'=>$model->return_date,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    // 'labelColOptions'=>['style'=>'width:10%'] 
                ],
               
                
                ], 
       
       ],
          
         [
             
            'columns'=>[
                
                 [
                    'attribute'=>'tr_expenses',
                    'label'=>'Travel Expenses',
                    'value'=>$model->tr_expenses,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    //'labelColOptions'=>['style'=>'width:10%'] 
                ],
                [
                    'attribute'=>'flight',
                    'label'=>'Flight',
                    'value'=>$model->flight,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    //'labelColOptions'=>['style'=>'width:10%'] 
                ],
               
                
                
                ],  
             
             ],
             
            
                
              
        ];
        
        
        
    

     

  
       
   $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$model->created_by."' ";  
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();
       
    $config[]=
    
    [
        'columns'=>[
            
            [
                    'attribute'=>'created',
                    'label'=>'Created At',
                    'value'=>$model->created,
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    //'labelColOptions'=>['style'=>'width:10%'] 
                ],
            [
                    'attribute'=>'created_by',
                    'label'=>'Created By',
                    'value'=>$row7['first_name']." ".$row7['last_name']."/".$row7['position'],
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                   // 'labelColOptions'=>['style'=>'width:10%'] 
                   // 'inputContainer' => ['class'=>'col-sm-3'],
                ],
            ]
        ];
        
        
        
$status=$model->status;
 
 if( $status=='processing' ){
                                                 
                                                 $label_class="label pull-left bg-pink";
                                             }else if($status=='closed'){
                                                  $label_class="label pull-left bg-red";
                                             }else if($status=='rfa' || $status=='drafting'){
                                                  $label_class="label pull-left bg-orange";
                                                 
                                             } 
                                            
                                             else{$label_class="label pull-left bg-green";}
    $config[]=[
        
         'columns'=>[
            
            [
                    'attribute'=>'status',
                    'label'=>'Status',
                    'format'=>'raw',
                    'value'=>'<small style="padding:10px;border-radius:13px;" class="'.$label_class.'">'.$model->status.'</small>',
                 
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:80%'],
                    //'labelColOptions'=>['style'=>'width:10%'] 
                ],
           
            ]
        
        
        ];    
    
    
    ?>

   <?= DetailView::widget([
    'model'=>$model,
    'condensed'=>false,
    'hideIfEmpty'=>false,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'attributes'=>$config,
    'panel' => [
         'heading' =>'<span><b>No : '.$model->tr_code.'</b></span>',
        'type' =>DetailView::TYPE_DEFAULT ,
        
       
        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
    ],
    
    'buttons1'=>'{update}',
    'updateOptions'=>[ // your ajax delete parameters
          'params' => ['id' => $model->id, 'custom_param' => true],
          'url'=>['update', 'id' => $model->id],
           'label'=>'<i class="fa  fa-edit"></i>'
        ]
       
])?>

 <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-users"></i> Employee(s) On Mission/Training</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
             <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                                         <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Title/Position</th>
                                        <th>Office/Unit/Department</th>
                                        <th>Delete</th>
                                         </tr> 
                                        <?php 
                                    
                                      foreach($rows1 as $r) {

$q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$r['employee']."' ";

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();       
       
       
 $q11=" select u.unit_name,l1.level_name,u2.unit_name as parent,l2.level_name as parent_level from erp_org_units as u 
inner join erp_org_units as u2 on u2.id=u.parent_unit inner join erp_org_levels as l1 on l1.id=u.unit_level 
inner join erp_org_levels as l2 on l2.id=u2.unit_level and u.id=(SELECT p.unit_id from erp_persons_in_position as p where p.person_id={$r['employee']}) ";
$command11 = Yii::$app->db->createCommand($q11);
$row11 = $command11->queryOne();
$i++;

   
                                    
                                    
                                     ?>
                                      <tr>
                                          
                               <td><?=$i  ?></td> 
                       
                       <td><?=$row7['first_name']  ?></td>
                       <td><?=$row7['last_name']  ?></td>
                       <td><?=$row7['position']  ?></td>
                       <td><?=$row11['unit_name']  ?></td>
                      <td> 
                                                 <?=Html::a('<i class="fa fa-trash"></i>',
                                              Url::to(["erp-travel-request/remove-employee",'id'=>$model->id,'emp'=>$r['employee']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active delete-action','title'=>'View Attachment Info','data-can-delete'=>$model->status=='drafting'|| $model->status=='rfa'] ); ?> </td>
                                          
                                                  
                  
                </tr>
                                     
                                     <?php }  ?>
               
                
                
               
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
         

               
                        
                        <!----------------------------travel clearance(s) ------------------------------------------ -->


          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-file-text"></i> Travel Clearance(s) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
          
            <div class="box-body">
                <p class="add-action">

<?=Html::a('<i class="fa fa-plus-square"></i> <span>Add Travel clearance</span>',
                                              Url::to(["erp-travel-clearance/create",'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-create','title'=>'Add New Travel Clearance'] ); ?>
</p>
             
       
       <?php 
       $q50 = new Query;
$q50	->select(['t.*'])->from('erp_travel_clearance as t')->where(['tr_id' =>$model->id])	;

$command50 = $q50->createCommand();
$rows50= $command50->queryAll(); 
$i=0;       
       ?>
<div class="table-responsive">

<table class="table fa table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                      
                                       <th>#</th>
                                        <th>Name </th>
                                        <th>Title/Position</th>
                                        <th>Destination</th>
                                        <th>Reason</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                         <th>Travel Expenses</th>
                                         <th>Flight</th>
                                         <th>Status</th>
                                        <th>View</th>
                                       
                                       
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
  
 $tr_drafting=$row5['status']=='drafting'; 
 $tr_creator=$row5['created_by']==$user;
 
 
                                  ?>
                                   
                                   
                                     <tr  class="<?php if($row5['is_new']==1){echo 'new';}else{echo 'read';}?>" >
                                         
                                      <td>
                                     <?= $i ?>
                                     
                                   
                 
                                     </td>
                                     <td>
                                     <?php echo $rows99["first_name"].' '.$rows99["last_name"] ; ?>
                 
                                     </td>
                                     <td><?php echo $rows99["position"] ; ?></td>
                                      <td>
                                            <?php echo $model->destination; ?>
                                        
                                        </td>
                                          
                                        <td><?php echo $model->purpose; ?></td>
                                            
                                            
                                            <td><?php 
                                             
                                               echo  $model->departure_date;  
                                            ?>
                                        </td>
                                        
                                         <td><?php echo $model->return_date ; ?></td>
                                         
                                          <td><?php echo $model->tr_expenses ; ?></td>
                                           <td><?php echo $model->flight ; ?></td> 
                                            <td>
                                           <?php
                                           $status= $row5["status"];
                                             if( $status=='processing' || $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;" class="'.$class.'">'.$status.'</small>'; ?></td>
                                           <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-travel-clearance/view-pdf",'id'=>$row5['id'],'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'Travel Clearance : '.$rows99["first_name"].' '.$rows99["last_name"] ] ); ?> </td>
                                             
                                     
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
            </div>
            
          </div><!--end body -->
         
        </div> <!-- /.box solid -->     


 
 <!--  -----------------------------end travel clearances---------------------------------------------->

          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-file-text"></i> Claim Form(s) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <p class="add-action">

<?=Html::a('<i class="fa fa-plus-square"></i> <span>Add Claim Form</span>',
                                              Url::to(["erp-claim-form/create",'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-create ','title'=>'Add New Claim Form'] ); ?>
</p>
             
       
       <?php 
     $q51 = new Query;
$q51	->select([
    'c.*',
    
])->from('erp_claim_form as c')->join( 'INNER JOIN', 
                'erp_travel_request as tr',
                'tr.id =c.tr_id'
            )->where(['c.tr_id' =>$model->id])	;

$command51 = $q51->createCommand();
$rows51= $command51->queryAll();


       ?>
<div class="table-responsive">

<table class="table fa table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                      
                                       <th>#</th>
                                        <th>Claim For</th>
                                        <th>Name </th>
                                        <th>Title/Position</th>
                                        <th>Title of Mission/Training</th>
                                       
                                        
                                         <th><?php 
                                            if($model->type==1){echo 'Destination';}else{echo 'Country';} 
                                                 
                                            ?>
                                        </th>
                                        <th>From</th>
                                        <th>To</th>
                                       
                                        <th>Rate(s)</th>
                                         <th>Amount</th>
                                        <th>Status</th>
                                        <th>View</th>
                                        
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
 <?php $i=0;
 foreach($rows51 as $row):
 $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['employee']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

 $i++;                                
  
 
 
 
                                  ?>
                                   
                                   
                                     <tr  class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                         <td>
                                     <?php echo  $i; ?>
                 
                                     </td>
                                      <td>
                                            <?php echo  $row['purpose'] ?>
                                        
                                        </td>
                                     <td>
                                     <?php echo $row7["first_name"].' '.$row7["last_name"] ; ?>
                 
                                     </td>
                                     <td><?php echo $row7["position"] ; ?></td>
                                     
                                     <td>
                                            <?php echo  $model->purpose; ?>
                                        
                                        </td>
                                        
                                        
                                        
                                      <td>
                                            <?php echo  $model->destination; ?>
                                        
                                        </td>
                                            
                                            
                                            <td><?php 
                                             
                                               echo  $model->departure_date;  
                                            ?>
                                        </td>
                                        
                                         <td><?php echo $model->return_date ; ?></td>
                                           <td><?php echo $row['rate'] ; ?></td>
                                          <td><?php echo $row["total_amount"]." ".$row["currancy_type"] ; ?></td>
                                         
                                           <td>
                                           <?php
                                           $status= $row["status"];
                                             if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;" class="'.$class.'">'.$status.'</small>'; ?></td>
                               
                                         
                                          
                                             <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-claim-form/view-pdf",'id'=>$row['id'],'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update','title'=>'Update person travel clearance Info' ] ); ?> </td>

                                             
                                           
                                            
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
            </div>
            <!-- /.box-body -->
         
                    
       </div>
        </div>
     
 <!-- ---------------------------------------end claim forms-------------------------------------------------------------->       
       
     

          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-paperclip"></i> Attachement(s)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body box-body table-responsive no-padding">
                <p class="add-action">

<?=Html::a('<i class="fa fa-plus-square"></i> <span>Add Attachment</span>',
                                              Url::to(["erp-travel-request-attachement/create",'tr_id'=>$model->id,'context'=>'view'
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-create ','title'=>'Add New Attachment'] ); ?>
</p>
             
       
       <?php 
     $q52 = new Query;
$q52	->select([
    'att.*',
    
])->from('erp_travel_request_attachement as att')->join( 'INNER JOIN', 
                'erp_travel_request as tr',
                'tr.id =att.tr_id'
            )->where(['att.tr_id' =>$model->id])	;

$command52 = $q52->createCommand();
$rows52= $command52->queryAll();
$i=0;


       ?>

              

<table class="table table-hover">
                                    <thead>
                                        <tr>
                                       
                                      
                                       <th>#</th>
                                        <th>Name</th>
                                        <th>Creator </th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        
                                        
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
    
                                     
                                  <?php foreach($rows52 as $row5):?>
                                   <?php $i++;  ?>
                                   
                                     <tr>
                                     
                                     
                                     <td>
                                     <?php echo $i; ?>
                 
                                     </td>
                                           
                                          

                                             <td><?php 
                                             
                                             $temp= explode(".",   $row5["attach_name"] );
   $ext = end($temp); 
                                         if(strtolower($ext) =='pdf'){
                                        echo '<i class="fa fa-fw fa-file-pdf-o margin-r-5"></i>'.$row5["attach_name"];
                                             
                                             
                                         }
                                         else if(strtolower($ext) =='jpg'){
                                         echo '<i class="fa fa-file-photo-o margin-r-5"></i>'.$row5["attach_name"];     
                                             
                                         }
                                         else if(strtolower($ext) =='png'){
                                           echo '<i class="fa fa-file-photo-o margin-r-5"></i>'.$row5["attach_name"];   
                                             
                                         }else{
                                          echo '<i class="fa fa-fw fa-file-pdf-o margin-r-5"></i>'.$row5["attach_name"];    
                                         }
                                         
                                         
                                         ?></td>
                            
                                          
                                           
                                            <td><?php 
                                            
                                              $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row5["created_by"]."' ";  
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();
                                            
                                            echo $row7['first_name']."".$row7['last_name']."[".$row7['position']."]";
                                            ?>
                                        
                                        
                                        
                                        
                                        </td>
                                           
                                             <td><?php echo $row5["created"]; ?></td>
                                            
 <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-travel-request-attachement/view-pdf",'id'=>$row5['id'],'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'View Attachment' ] ); ?> </td>
                                            
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-trash"></i>',
                                              Url::to(["erp-travel-request-attachement/delete",'id'=>$row5['id'],'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-danger btn-sm active delete-action','title'=>'Delete Attachemnt','data-can-delete'=>$model->status=='drafting' ] ); ?> </td>
                                          
                                        
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                           
                                    
                                        


                                    </tbody>
                                </table>
           
            <!-- /.box-body -->
         
                    
       </div>
        </div>
        
  <!-- --------------------------------work flwo actions----------------------------------------------------------------------->      
     
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-file-text"></i> Work Flow Action(s) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
          
            <div class="box-body">
  
  <?php $model1= new ErpTravelRequestApproval()  ?>    
            
<?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);

?> 

         
     
      <?= $form->field($model1, 'action',[
                'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                   'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Request For Correction', 'value' => 1, 'uncheckValue' => null,'disabled'=>true]) ?>
       
        <?=  $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Forward', 'value' => 2, 'uncheckValue' => null, ]) ?>
       <?= $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Approve', 'value' => 3, 'uncheckValue' => null,'disabled'=>false]) ?>
       
                  

<?php
   ActiveForm::end();
                            
 ?>                  
                  
              <div id="form1" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['erp-travel-request-approval/work-flow'],
        'method' => 'post'
       ]);

?>

     <?= $form->field($model1, 'tr_id')->hiddenInput(['value'=>$model->id])->label(false);?>
     <?= $form->field($model1, 'action')->hiddenInput(['value'=>'rfa'])->label(false);?>
  	 <?= $form->field($model1, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Position')?>                
                    
                    <?= $form->field($model1, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model1, 'remark')->textarea(['rows' => '6']) ?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> Send ', ['class' => 'btn btn-primary ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>    
                        
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['erp-travel-request-approval/work-flow'],
        'method' => 'post'
       ]);

?>

  <?= $form->field($model1, 'tr_id')->hiddenInput(['value'=>$model->id])->label(false);?>
     <?= $form->field($model1, 'action')->hiddenInput(['value'=>'forward'])->label(false);?>
  <?= $form->field($model1, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Position')?>                
                    
                    <?= $form->field($model1, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model1, 'remark')->textarea(['rows' => '6']) ?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div>  

<!-- -----------------approve--------------------------------------->
<div id="form3" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['erp-travel-request-approval/work-flow'],
        'method' => 'post'
       ]);

?>
     <?= $form->field($model1, 'tr_id')->hiddenInput(['value'=>$model->id])->label(false);?>
     <?= $form->field($model1, 'action')->hiddenInput(['value'=>'approve'])->label(false);?>
  	<?= $form->field($model1, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select1'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Position')?>                
                    
                    <?= $form->field($model1, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names1'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model1, 'remark')->textarea(['rows' => '6']) ?>

<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?>
</div> 
          </div><!--end body -->
         
        </div> <!-- /.box solid -->      
 <!-- ---------------------------------end-----------------------------------------------------------------> 

    
          </div><!--end body -->
         
        </div> <!-- /.box solid -->     

 </div> <!-- /.box wrapper col-->
 
            
                        
               
        
        </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          


<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  
$url2=Url::to(['update','id'=>$model->id,'flow'=>$flow]);
$url3=Url::to(['erp-rquest_id/view-pdf','id'=>$model->id]); 
$url4=Url::to(['erp-rquest_id/view-pdf','id'=>$model->id]);
$currentURL=$this->context->route;
$script = <<< JS


console.log('{$currentURL}');

$(document).ready(function(){
    
    $('input:radio[name="ErpTravelRequestApproval[action]"]').each(function () { $(this).prop('checked', false); });
    
    $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide();
        $("#form"+value).show();
    });
});
 
 
 
$(function() {
   
   $('input:radio[name="Erprquest_id[action]"]').each(function () { $(this).prop('checked', false); });
});


  
//--------------------------------------------updating supporting doc---------------------------------------------

  $('.action-delete-doc').on('click',function () {


var disabled=$(this).attr('disabled');



if(disabled){
    
swal("You are not allowed to delete  this document!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
    swal({
        title: "Are you sure?",
        text: "You want to delete this document",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete ",
        closeOnConfirm: false
    }, function () {
        
      
// make post to yii2--delete----if not u get error action 

$.post(url, function(data, status){
    
   if(data){
        swal("Document Deleted !", "", "success");
        location.reload();
   }else{
       
       swal("Unable to delete document !", "", "error");
   }
    
  });
        
    });
  
  
 

}



return false;
  });
     
 
 //----------------------------update--------------------------------------------
 
 $('.action-update').on('click',function () {


var disabled=$(this).attr('disabled');



if(disabled){
    
swal("You are not allowed to update  this item!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
 $('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
   
  $('#modal-action .modal-title').text($(this).attr('title'));

 

}



return false;
  });
     
       
 //---------------------------------------delete item-------------------------------------------------------      
   
    $('.action-delete').on('click',function () {


var disabled=$(this).attr('disabled');

if(disabled){
    
swal("You are not allowed to delete  this item!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
    swal({
        title: "Are you sure?",
        text: "You want to delete this item",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete ",
        closeOnConfirm: false
    }, function () {
        
       flag=true;
console.log(flag);
// make post to yii2--delete----if not u get error action 

$.post(url, function(data, status){
    
   if(data){
        swal("Deleted !", "", "success");
        location.reload();
   }else{
       
       swal("Unable to delete !", "", "error");
   }
    
  });
        
    });
  
  
 

}



return false;
  });      
       
  
  //--------------------------------------------------view-----------------------------------------
    

 $(function () {
    //Initialize Select2 Elements
    $(".Select2").select2({width: '100%' });
     
 });

$('#employees-select').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');
    });
});

$('#employees-select').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names').val([]);
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');

});

}else{ $('#employees-names').val([]);

$('#employees-names').trigger('change.select2');
    
}   
});



//----------------------------selec0----------------------------------------------------------
 $('#employees-select0').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');
    });
});

$('#employees-select0').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names0').val([]);
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');

});

}else{ $('#employees-names0').val([]);$('#employees-names0').trigger('change.select2');}
   
});


//---------------------------------select1--------------------------------------------------
$('#employees-select1').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names1').trigger('change.select2');
    });
});

$('#employees-select1').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names1').val([]);
    $.each(array, function(i,e){
    $("#employees-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names1').trigger('change.select2');

});

}else{ $('#employees-names1').val([]);$('#employees-names1').trigger('change.select2');}

});





//---------------------------------------------------------------------------------





//------------------------------------update doc link-------------------------------------------



JS;
$this->registerJs($script);

?>
