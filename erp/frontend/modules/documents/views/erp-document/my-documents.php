<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Documents';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 

 
  .doc-desc{
   height:100px; 
   width: 300px; 
   overflow: auto;
   
}

  th {

text-align: center;
}

</style>
<div class="document-sharing-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Share Document', ['create'], ['class' => 'btn btn-success active','title'=>'Share a  New Document']) ?>
    </p>
   
</div>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header">
   <h3 class="card-title"><i class="fa fa-tag"></i>My Documents</h3>
 </div>
 <div class="card-body">

 
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
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
<?php 

$q=" SELECT distinct(f.document),timestamp FROM erp_document_flow_recipients as f
 
where f.sender='".Yii::$app->user->identity->user_id."' or (f.recipient='". Yii::$app->user->identity->user_id."' and status='archived') order by timestamp desc  ";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
   $i=0;
   
   
$q7=" SELECT p.position_code FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
where pp.person_id='".Yii::$app->user->identity->user_id."' and pp.status=1";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 



if(trim($row7['position_code'])=='MD' 
|| trim($row7['position_code'])=='DMD' 
|| trim($row7['position_code'])=='ITENG'){
  $disabled=false;  
    
}else{
    
    $disabled=true;
}

?>

<div class="table-responsive">
 <table class="table  table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>Document Code</th>
                                        <th>Doc Type</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                         <th>Status</th>
                                        <th>Severity</th>
                                        <th>Owner Status</th>
                                        <th>Created</th>
                                         <th>Expiry</th>
                                        
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                       $q=" SELECT doc.*,t.type as doc_type, s.severity as severity_name, s.code as s_code FROM erp_document as doc
 inner join erp_document_type as t on doc.type =t.id 
 inner join erp_document_severity as s  on s.id =doc.severity 
 where doc.id='".$row['document']."' order by timestamp desc ";
 $com = Yii::$app->db->createCommand($q);
 $row2 = $com->queryOne();

                                    $i++;
                                    ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row2['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        <td><?=$i ?></td>
                                        
                                                             <td nowrap>     
                                                               <div class="centerBtn">
   
   
    
                                                 <?=Html::a('<i class="fa  fa-eye"></i> View',
                                              Url::to(["erp-document/pdf-viewer",'id'=>$row2['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Document Info '] ); ?>| 
                                            
                                             
                                                 <?=Html::a('<i class="fa  fa-reply-all"></i> Recall</i>',
                                              Url::to(["erp-document/recall",'id'=>$row2['id']
                                           ])
                                          ,['class'=>'btn-success btn-sm active recall-action','title'=>'Recall Document','disabled'=>$disabled] ); ?> |
                                           
                                                 <?=Html::a('<i class="fa fa-recycle"></i> History',
                                              Url::to(["erp-document/doc-tracking",'id'=>$row2['id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active action-view','title'=>'Document Tracking History' ] ); ?>
                                          
                                          
        </div></td>
                                    <td nowrap><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row2["doc_code"],Url::to(['erp-document/view1','id'=>$row2["id"]]), ['class'=>'']) ?></td>
                                        
                                    <td nowrap>
                                            <?php
                                          
                                           echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. $row2["doc_type"].'</small>';
                                            
                                           ?>
                                          
                                          
                                         </td>
                                            <td>
                                            <?=
                                           $row2["doc_title"]
                                            
                                           ?>
                                          
                                          
                                         </td>
                                         <td>
                                             <div class="doc-desc">
                                                 
                                                  <?php echo $row2["doc_description"]  ;?>
                                             </div>
                                           
                                          
                                          
                                         </td>
                                         
                                          <td>
                                            <?php
                                               $status= $row2["status"];
                                         if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='closed' || $status=='expired'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             else{$class="label pull-left bg-yellow";}
                                             
                                             echo '<small style="padding:5px;" class="'.$class.'">'.$status.'</small>';
                                             
                                         
                                            
                                           ?>
                                          
                                          
                                         </td>
                                           
                                           <td><?php 
                                           
                                             
                                                $s=$row2["s_code"];
                                             
                                              if( $s=='N'){
                                                 
                                                 $class="label pull-left bg-green";
                                                 
                                             }else if($s=='C'){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             else if($s=='U' ){
                                                  
                                                  $class="label pull-left bg-pink";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-orange ";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$row2["severity_name"].'</small>';
                                               
                                               
                                           
                                           ?></td> 
                                          
                                                 <td>
                                            <?php
                                               $user= Yii::$app->user->identity->user_id;
                                         if( $user==$row2["creator"]){
                                                 
                                                 $class="label pull-left bg-blue";
                                                 echo '<small style="padding:5px;" class="'.$class.'">OWNER</small>';
                                             }
                                             else{
                                                 $class="label pull-left bg-black";
                                                 
                                                    echo '<small style="padding:5px;" class="'.$class.'">SHARED</small>';
                                             }
                                             
                                          
                                             
                                         
                                            
                                           ?>
                                          
                                          
                                         </td>
                                             <td><?php echo $row2["timestamp"] ; ?></td>
                                              <td nowrap><?php echo $row2["expiration_date"] ; ?></td>
                                            
                                            
                                        </tr>

                                     
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                </table>
                                </div>

                               
 </div>

 </div>
 
 
 </div>

</div>


        <?php
   
$script = <<< JS

$('.recall-action').on('click',function () {

var disabled=$(this).attr('disabled');
console.log(disabled);

if(typeof disabled !=='undefined' && disabled!=null ){

   
swal("You are not Allowed to perform this operation!", "", "error");

return false;

    
}else{
 
      var url=$(this).attr('href');
 
    swal({
        title: "Are you sure?",
        text: "You want to recall the document",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Recall ",
        closeOnConfirm: false
    }, function () {
        
$.post( url, function( data ) {
  //$( ".result" ).html( data );
});

        
    });
}   
    

    
    return false;

});

JS;
$this->registerJs($script);



?>



