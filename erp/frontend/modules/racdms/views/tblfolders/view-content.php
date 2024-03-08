<?php

use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\UserHelper;
use common\models\Tbldocuments;
use common\models\User;
use common\models\Tbldocumentcontent;
?>

<style>
    
 
.folders-list {
  
  margin: 0;
  padding: 0;
}

.folders-list > .item {
  border-radius: 0.25rem;
  background: #ffffff;
  padding: 10px 0;
}

.folders-list > .item::after {
  display: block;
  clear: both;
  content: "";
}

.folder-img {
  float: left;
}

 .folder-img img {
  height: 32px;
  width: 32px;
}

 .folder-info {
  margin-left: 40px;
}

.folder-title {
  font-weight: 550;
}

.folder-description {
  color: #6c757d;
  display: block;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>

  <?php
if (!function_exists('getIconByType')){            
function getIconByType($type){
    
 $fileTypes=array("pdf"=>"far fa-file-pdf","doc"=>"far fa-file-word","docx"=>"far fa-file-word","ppt"=>"far fa-file-powerpoint","pptx"=>"far fa-file-powerpoint");  
 $fa_icon=null;
 
 foreach($fileTypes as $key=>$ficon){
     
     if($key==$type){
         
        $fa_icon=$ficon." fa-lg";
        break;
     }
     
    if(!$fa_icon){
        
       $fa_icon="far fa-file fa-lg"  ;
    }
    
    
 }
   
   return $fa_icon; 
}

}
if (!function_exists('getRowItem')){
function getRowItem($obj){

 
 if ($obj instanceof common\models\Tblfolders) {
  
     $folder=$obj;
     
               
            $user=UserHelper::getUserInfo($folder->user) ;
   
            $pos=UserHelper::getPositionInfo($folder->user);
  
            $owner=$user['first_name']." ".$user['last_name']." / ".$pos['position']; 
           
          
           //-------------------------------folder icon-----------------------------------------------
           echo Html::tag('div',Html::tag('i','',
           ['aria-hidden'=>true,'class'=>'fa fa-folder fa-lg','style'=>"color:#F2B02B"]),['class'=>'folder-img'])  ;
          
          //------------------------folder info------------------------------------------------------- 
           echo Html::tag('div',Html::a($folder->name,['tblfolders/view2','id'=>$folder->id,'url'=>Yii::$app->request->url],
           ['class'=>'folder-title']).Html::tag('span','Owner : '.
           Html::tag('span',$owner,['style' => 'color:black;font-weight:500']).
           Html::tag('span','|',['style' => 'padding:0 8px 0 8px']).'Last Modified : '.
           Html::tag('span',$folder->timestamp,['style' => 'color:black;font-weight:500']).'</br>'.
         
           'Comment : '.$folder->comment,
           ['class'=>'folder-description'])
           ,['class'=>'folder-info'])  ; 
     
     
 }else if($obj instanceof common\models\Tbldocuments){
     
            
            $doc=$obj;
            $content=$doc->getLatestContent();
            
            $fa_icon=getIconByType(strtolower($content->fileType));
           
            
            $user=UserHelper::getUserInfo($doc->owner) ;
   
            $pos=UserHelper::getPositionInfo($doc->owner);
  
            $author=$user['first_name']." ".$user['last_name']." / ".$pos['position']; 
           
          
           //-------------------------------folder icon-----------------------------------------------
           echo Html::tag('div',Html::tag('i','',
           ['aria-hidden'=>true,'class'=>$fa_icon,'style'=>"color:#F2B02B"]),['class'=>'folder-img'])  ;
          
           if($content->fileType!="zip"):
          //------------------------folder info------------------------------------------------------- 
           echo Html::tag('div',Html::a($content->orgFileName,['tbldocuments/view','id'=>$doc->id],
           ['class'=>'folder-title']).Html::tag('span','Author : '.
           Html::tag('span',$author,['style' => 'color:black;font-weight:500']).
           Html::tag('span','|',['style' => 'padding:0 8px 0 8px']).'Released Date : '.
           Html::tag('span',$doc->date,['style' => 'color:black;font-weight:500']).'</br>'.
         
           'Comment : '.$doc->comment,
           ['class'=>'folder-description'])
           ,['class'=>'folder-info'])  ;
           
           else:
                 //------------------------folder info------------------------------------------------------- 
           echo Html::tag('div',Html::a($content->orgFileName." 'Click To Download' ",Url::to($content->getContentPath()),
           ['class'=>'folder-title']).Html::tag('span','Author : '.
           Html::tag('span',$author,['style' => 'color:black;font-weight:500']).
           Html::tag('span','|',['style' => 'padding:0 8px 0 8px']).'Released Date : '.
           Html::tag('span',$doc->date,['style' => 'color:black;font-weight:500']).'</br>'.
         
           'Comment : '.$doc->comment,
           ['class'=>'folder-description'])
           ,['class'=>'folder-info'])  ;
           
           endif;
     
 }   
       
    
 }
}
?>



<?php
 // extract($params);
  $currentUser=Yii::$app->user->identity;
  
  $getOwner=function() use($node){
  
 if($node->user!=null){
     
    $user=UserHelper::getUserInfo($node->user) ;
   
    $pos=UserHelper::getPositionInfo($node->user);
  
    return $user['first_name']." ".$user['last_name']." / ".$pos['position'];  
 }
 else{
     
     return null;
 }
 
  
    
};

// Folder DetailView 
$attributes = [
   
   
    [
        
        'label'=>'Name',
        'value'=>$node->name ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    [
        
        'label'=>'Owner',
        'value'=>$getOwner() ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    [
        
        'label'=>'Date Created',
        'value'=>$node->timestamp ,
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
     
     
    [   'label'=>'Comment',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $node->comment . '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA, 
        'options'=>['rows'=>4]
    ]
   
  
];


$editBtn=Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $node->id], ['class' => 'kv-action-button action-update-content ','']);

?>



<div class="row">
    <div class="col-12">
       
                  <?php
                  
// View file rendering the widget
echo DetailView::widget([
    'model' => $node,
    'attributes' => $attributes,
    'mode' => 'view',
    'bsVersion'=>4,
    'bordered' =>false,
    'striped' =>false,
    'condensed' => true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'left',
    'vAlign'=>'middle',
    'fadeDelay'=>1000,
    'panel' => [
        'type' =>'default', 
        'heading' => '<h5><i class="fas fa-folder-open"></i> Folder Details</h5>',
       
    ],
    'deleteOptions'=>[ // your ajax delete parameters
        'params' => ['id' =>$node->id, 'kvdelete'=>true],
    ],
     'buttons1' =>$editBtn,
    'container' => ['id'=>'kv-demo'],
    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
]);
                  ?>
                  
                  
  </div>         
     </div> 
     
       <div class="row mt-3">
              
              <div class="col-12">
                  
              <?php
                  
                  //-----------------first level node children-[folders]--------------------------
                  $child_folders = $node->children(1)->all();
                  
                   //----------------------[documents]---------------------------------------------
                  $documents=Tbldocuments::find()->where(['folder'=>$node->id])->all();
                   ?> 
                   
                   <?php if(empty( $child_folders) && empty($documents))  : ?>
                   
                   <div class="callout callout-danger">
                 

                  <p><b>This folder is empty !</b></p>
                </div>
                   <?php else : ?>
                  
                  
                  <h5>
                    <i class="fas fa-folder-open"></i> Folder Content
                   
                  </h5>
                </div>   
              <div class="col-12 table-responsive">
               
               
                <table class="table table-folders">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Actions</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                 
                   
                   <?php  if(!empty($child_folders)) :?>
                   
                   <?php foreach ($child_folders as $f) :?>
                   
                   <?php  if($f->getAccessMode($currentUser)>=2)  :?>
                   
                  
                  
                   <?php  
                   
                    $f_count=Html::tag('span',$f->children(1)->count(),
                    ['class'=>'badge bg-warning']);
                    
                     $d_count=Html::tag('span',Tbldocuments::find()->where(['folder'=>$f->id])->count(),
                     ['class'=>'badge bg-success']);
                 
                 
                   ?>
                      
                    <tr>
                      <td>
                     
                     <?=getRowItem($f)?>
                    
                  
                      </td>
                     
                    <td>
                      <?php 
                      
                      echo ' Folders : '.$f_count.'</br>';
                      echo  'Documents : '.$d_count;
                      ?> 
                        
                    </td>
                      
                    <td>
                        
                         <?php if($currentUser->user_id==$f->user || $currentUser->user_level==User::ROLE_ADMIN) :?>   
                        
                      <?=Html::a('<i class="fas fa-pencil-alt"></i>',
                                              Url::to(["tblfolders/update",'id'=>$f->id,
                                           ])
                                          ,['class'=>'btn-outline-success btn-sm action-edit-folder ','target'=>2,
                                          'title'=>'Edit Folder','disabled'=>true,'data-id'=>$f->id] ); ?>
                                 <?php endif?>            
                                          
                              <?php if($currentUser->user_id==$f->user || $currentUser->user_level==User::ROLE_ADMIN ) :?>             
                            | <?=Html::a('<i class="far fa-trash-alt"></i>',
                                              Url::to(["tblfolders/delete",'id'=>$f->id
                                           ])
                                          ,['class'=>'btn-outline-danger btn-sm  action-delete-folder','target'=>2,
                                          'title'=>'Delete Folder','disabled'=>false] ); ?>  
                                          
                                          <?php endif?>
                        
                        
                    </td>
                      
                    </tr>
                   
                  <?php endif; endforeach;?> 
                  
              
                   <?php endif;?> 
              
    <!-- ------------------------------documents inside folder--------------------------------------------------------------------------------->  
                  <?php  if(!empty($documents)) :?>
                  
                   <?php foreach ($documents as $doc) :?>
                   
                   <?php $lock=$doc->status?'<i class="fa fa-unlock"></i>':'<i class="fas fa-lock"></i>'; 
                        
                         $btn_class=$doc->status?'btn-outline-warning btn-sm  check-in':'btn-outline-secondary btn-sm  check-out';
                   ?>
                 
                   <tr>
                      <td>
                     
                    <?=getRowItem($doc)?>
                    
                  
                      </td>
                     
                    <td>
                      <?php 
                      if($doc->status){
                        
                          echo Html::tag('span','Checked-out',['class'=>"badge badge-warning"]);
                      }else{
                          
                        echo Html::tag('span','Checked-in',['class'=>"badge badge-primary"]);
                        }
                     
                      ?> 
                        
                    </td>
                      
                    <td>
                     <?php if($currentUser->user_id==$doc->owner || $currentUser->user_level==User::ROLE_ADMIN ) :?>     
                     
                     
                      <?=Html::a('<i class="fas fa-pencil-alt"></i>',
                                              Url::to(["tbldocuments/edit",'id'=>$doc->id,
                                           ])
                                          ,['class'=>'btn-outline-success  btn-sm action-update-doc ','target'=>1,
                                          'title'=>'Edit document','disabled'=>true] ); ?>
                                          
                                           <?php endif;?>
                                           
                                           <?php if($currentUser->user_id==$doc->owner || $currentUser->user_level==User::ROLE_ADMIN ) :?>    
                                           
                                                 <?=Html::a('<i class="far fa-trash-alt"></i>',
                                              Url::to(["tbldocuments/delete",'id'=>$doc->id
                                           ])
                                          ,['class'=>'btn-outline-danger btn-sm  action-delete-doc','target'=>1,
                                          'title'=>'Delete Document','disabled'=>false] ); ?> 
                                          
                                           <?php endif;?>
                                           
                                         <?php if($currentUser->user_id==$doc->owner || $currentUser->user_level==User::ROLE_ADMIN ) :?>     
                                          
                                          <?=Html::a($lock,
                                              Url::to(["tbldocuments/lock",'id'=>$doc->id
                                           ])
                                          ,['class'=>$btn_class,'title'=>$doc->status?'Check-In':'Check-Out','disabled'=>false] ); ?> 
                        <?php endif;?>
                        
                    </td>
                      
                    </tr>
                   
                   <?php endforeach;?>
                  
                 <?php endif; ?>
                 
                  </tbody>
                </table>
                
                 <?php endif; ?>
             </div>
             </div>
             
           

<?php
 $script = <<< JS

 


JS;
$this->registerJs($script);



?>