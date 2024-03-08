<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;

?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
  
  th {

text-align: center;
}

  .desc{
   height:100px; 
   width: 300px; 
   overflow: auto;
   
}

</style>


    <p>
        <?= Html::a("<i class='fas fa-share-square'></i> Share Document", ['create'], ['class' => 'btn btn-success btn-sm active','title'=>'Share a  New Document']) ?>
        
     
                                          
    </p>
   



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header">
   <h3 class="card-title"><i class="far fa-edit"></i> Draft(s)</h3>
 </div>
 <div class="card-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton:true,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
   <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');
  ?>
  
   <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= $msg ?>
              </div>
    <?php endif; ?> 
    
    
<?php 

$q=" SELECT doc.*,t.type as doc_type,s.severity,s.code as s_code FROM erp_document as doc
 left join erp_document_type as t on doc.type =t.id 
 inner join erp_document_severity s on s.id=doc.severity
 where doc.creator='".Yii::$app->user->identity->user_id."' and doc.status='drafting' order by timestamp desc ";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
     $i=0;
?>

 <div class="table-responsive">
 <table  class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>Document Code</th>
                                        <th>Doc Type</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Created</th>
                                         <th>Expiry</th>
                                        <th>Severity</th>
                                        <th>Status</th>
                                        
                                    
                                         
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                      
                                    $i++;
                                    ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        <td><?=$i ?></td>
                                        <td nowrap>
                                            
                                                               <div class="centerBtn">
   
   
    
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-document/pdf-viewer",'id'=>$row['id'],'status'=>$row["status"]
                                           ])
                                          ,['class'=>'btn btn-info btn-sm  ','title'=>'View Document Info'] ); ?>| 
                                            
                                             
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-document/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn btn-success btn-sm  ','title'=>'Update Document Info','disabled'=>$row["status"]!='drafting'] ); ?>|
                                           
                                                 <?=Html::a('<i class="fa fa-remove"></i> Delete',
                                              Url::to(["erp-document/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn btn-danger btn-sm  action-delete','title'=>'Delete Document Info','disabled'=>$row["status"]!='drafting'] ); ?>
        </div>     
                                            
                                            
                                        </td>
                                    <td nowrap><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row["doc_code"],Url::to(['erp-document/pdf-viewer','id'=>$row["id"]]), ['class'=>'']) ?></td>
                                        
                                    <td  nowrap>
                                            <?php
                                          
                                           echo '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'. $row["doc_type"].'</small>';
                                            
                                           ?>
                                          
                                          
                                         </td>
                                            <td>
                                            <?=
                                           $row["doc_title"]
                                            
                                           ?>
                                          
                                          
                                         </td>
                                         <td>
                                          <div class="desc"
                                            >
                                       <?php echo $row["doc_description"]  ;?>
                                                    
                                                     </div>
                                          
                                          
                                         </td>
                                         
                                         <td><?php echo $row["timestamp"] ; ?></td>
                                        
                                        <td><?php echo $row["expiration_date"] ; ?></td>
                                         <td ><?php 
                                         
                                              
                                                $s=$row["s_code"];
                                             
                                              if( $s=='N'){
                                                 
                                                 $class="label pull-left bg-green";
                                                 
                                             }else if($s=='C'){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             else if($s=='U' ){
                                                  
                                                  $class="label pull-left bg-pink";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-orange ";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$row["severity"].'</small>';
                                               
                                               
                                               
                                               
                                               
                                         
                                         ?></td> 
                                          <td>
                                            <?php
                                               $status= $row["status"];
                                             if( $status=='processing'  ){
                                                 
                                                 $class="label pull-left bg-lime";
                                               
                                             }
                                             else if($status=='drafting'){
                                                
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($status=='closed' ||$status=='rejected'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             
                                             
                                             else{$class="label pull-left bg-orange";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                         
                                            
                                           ?>
                                          
                                          
                                         </td>
                                           
                                           
      
                                             
                                            
                                            
                                            
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

 $('.action-delete').on('click',function () {

 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Document will be Deleted !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
 
});
  }
})
    
    return false;

});

JS;
$this->registerJs($script);



?>



