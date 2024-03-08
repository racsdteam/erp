<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved Documents';
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


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fa fa-tag"></i>Approved Documents</h3>
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
<?php 
  
  $i=0; 
 $q44=" SELECT doc_ap.* FROM erp_document_approval  as doc_ap inner join erp_document as doc
     on doc.id=doc_ap.document where   doc_ap.approval_action='approved' and doc_ap.approval_status='final' 
and doc.creator='".Yii::$app->user->identity->user_id."' order by doc_ap.approved desc";
 $com44 = Yii::$app->db->createCommand($q44);
 $rows = $com44->queryall();
  //var_dump( $rows);die();
 
   
?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                        <th>Document Code</th>
                                        <th>Title</th>
                                        <th>Doc Type</th>
                                     
                                        <th>Description</th>
                                        <th>Status</th>
                                        
                                        <th>Approved</th>
                                        <th>Approved By</th>
                                        <th>Severity</th>
                                        <th>Remark</th>
                                        
                                         <th>Doc ReView</th>
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 

                                    //---------------------------doc latest version info-----------------------------------
                                     $query = new Query;
                                     $query	->select([
                                         'doc.*','doc_type.type','rev.version_number'
                                         
                                     ])->from('erp_document as doc ')->join('INNER JOIN', 'erp_document_type as doc_type',
                                         'doc.type=doc_type.id')->join('INNER JOIN', 'erp_document_version as rev',
                                         'rev.document=doc.id')->where(['doc.id' =>$row['document']])->orderBy(['version_number' => SORT_DESC]);
                         
                                     $command = $query->createCommand();
                                     $rows2= $command->queryAll();
                                     $i++;

                                     //----------------------------------------latest version
                                     $row2=$rows2[0];

                                     
                                    
                                    ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                          <td>
                                            <?=
                                           $i
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                    <td nowrap><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row2["doc_code"],Url::to(['erp-document/view','id'=>$row2["id"]]), ['class'=>'kv-author-linkx']) ?></td>
                                    <td>
                                            <?=
                                           $row2["doc_title"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                            <?php
                                          
                                           echo '<small style="padding:10px;border-radius:13px;" class="label pull-left bg-green">'. $row2["type"].'</small>';
                                            
                                           ?>
                                          
                                          
                                         </td>
                                           
                                         <td>
                                            <div class="doc-desc"
                                            >
                                       <?php echo $row2["doc_description"]  ;?>
                                                    
                                                     </div>
                                            
                                            </td>
                                            
                                             <td><?php
                                             $status=$row2["status"];
                                             
                                              if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='closed'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;border-radius:13px" class="'.$class.'">'.$row2["status"].'</small>';
                                              ?></td>
                                             
      
                                             
                                          
                                            <td><?php echo $row["approved"] ; ?></td>
                                        
                                           
                                            <td > <?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['approved_by']."' and pp.status=1 ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name'];
                                           
                                          // echo $row7['position'];
                                           echo  $pos." [ ".$full_name." ]";
                                          
                                            ?> </td>
                                            
                                             <td><?php echo '<kbd class="bg-pink">'. $row2["severity"] .'</kbd>' ; ?></td>
                                            
                                            <td>
                                              <?php
                                              echo '<em>'.$row['remark'].'</em>'
                                              ?>
                                                
                                            </td>

                                            
                                             <td> 
                                                 <?=Html::a('<i class="fa  fa-eye"></i>',
                                              Url::to(["erp-document/pdf-viewer",'id'=>$row2['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'View Document Info '] ); ?> </td>
                                            
                                            
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



