<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Documents';
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

 tr > th{
     
     white-space: nowrap;
  }

.nowrap{white-space: nowrap;}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fa fa-tag"></i>All Documents</h3>
 </div>
 <div class="card-body">

 
 
<?php 
$i=0; 
 
                                     $query = new Query;
                                     $query	->select([
                                         'd.*','t.type as d_type','s.severity','s.code as s_code'
                                         
                                     ])->from('erp_document as d ')->join('INNER JOIN', 'erp_document_type as t',
                                         'd.type=t.id')->join('INNER JOIN', 'erp_document_severity as s',
                                         'd.severity=s.id')->orderBy([
  'd.timestamp' => SORT_DESC
  
]);
                         
                                     $command = $query->createCommand();
                                     $rows2=$command->queryAll();
 
?>

 <div class="table-responsive">
 <table id="tblDoc"  class="table  table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                         <th align="center">Actions</th>
                                        <th>Doc Number</th>
                                        <th>Title</th>
                                        <th>Doc Type</th>
                                     
                                        <th>Description</th>
                                        <th>Doc Origin</th>
                                         <th>Doc Creator</th>
                                       
                                        <th>timestamp</th>
                                         
                                         <th>Expiry</th>
                                        <th>Status</th>
                                         <th>Severity</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows2 as $row2):?>
                                 
                                    <?php $i++;?>
                                  
                                    
                                    <tr>
                                        <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         
                                         <td nowrap>
                                             
                                                                                    <div class="centerBtn">
   
 
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-document/pdf-viewer",'id'=>$row2['id'],'flow'=>$row['flow_id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-viewx','title'=>'View Document Info'] ); ?> |
                                            
                                           
                                                 <?=Html::a('<i class="fa fa-recycle"></i> History',
                                              Url::to(["erp-document/doc-tracking",'id'=>$row2['id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active action-view','title'=>'Document Tracking History' ] ); ?>
                                            
                                             
        </div>        
                                             
                                             
                                             
                                             
                                             
                                         </td>
                                         
                                         
                                    <td nowrap><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row2["doc_code"],Url::to(['erp-document/pdf-viewer','id'=>$row2["id"]]), ['class'=>'']) ?></td>
                                    <td>
                                            <?=
                                           $row2["doc_title"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td nowrap>
                                            <?php
                                          
                                           echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. $row2["d_type"].'</small>';
                                            
                                           ?>
                                          
                                          
                                         </td>
                                           
                                         <td >
                                             
                                             <div class="doc-desc"
                                            >
        <?php echo $row2["doc_description"]  ;?>
                                                     </div>
                                           
                                          
                                          
                                         </td>
                                         
                                          <td>
                                            <?php echo $row2["doc_source"]  ;?>
                                          
                                          
                                         </td>
                                         
                                          <td > <?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row2['creator']."' and pp.status=1";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name'];
                                           
                                          // echo $row7['position'];
                                           echo  $pos." [ ".$full_name." ]";
                                          
                                            ?> </td>
                                         
                                           <td>
                                            <?php echo $row2["timestamp"]  ;?>
                                          
                                          
                                         </td>
                                           
                                           

                                             <td class="nowrap">
                                            <?php echo $row2["expiration_date"]  ;?>
                                          
                                          
                                         </td>
                                             
                                             <td><?php
                                             $status=$row2["status"];
                                             
                                              if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-orange";
                                                 
                                             }else if($status=='closed' ||$status=='expired'){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             else if($status=='approved' ){
                                                  
                                                  $class="label pull-left bg-green";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-pink";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$row2["status"].'</small>';
                                              ?></td>
                                              
                                            
                                             
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
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$row2["severity"].'</small>';
                                               
                                               
                                               
                                               
                                               
                                               
                                               ?></td>
                                               
                                             
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


 
  
 
JS;
$this->registerJs($script);



?>



