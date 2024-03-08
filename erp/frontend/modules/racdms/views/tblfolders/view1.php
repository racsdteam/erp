
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
use common\models\Tbldocumentcontent;



/**
 * @var View $this
 * @var Tree $node
 * @var ActiveForm $form
 * @var array $formOptions
 * @var string $keyAttribute
 * @var string $nameAttribute
 * @var string $iconAttribute
 * @var string $iconTypeAttribute
 * @var string $iconsListShow
 * @var array|null $iconsList
 * @var string $formAction
 * @var array $breadcrumbs
 * @var array $nodeAddlViews
 * @var mixed $currUrl
 * @var boolean $isAdmin
 * @var boolean $showIDAttribute
 * @var boolean $showNameAttribute
 * @var boolean $showFormButtons
 * @var boolean $allowNewRoots
 * @var string $nodeSelected
 * @var string $nodeTitle
 * @var string $nodeTitlePlural
 * @var array $params
 * @var string $keyField
 * @var string $nodeView
 * @var string $nodeAddlViews
 * @var array $nodeViewButtonLabels
 * @var string $noNodesMessage
 * @var boolean $softDelete
 * @var string $modelClass
 * @var string $defaultBtnCss
 * @var string $treeManageHash
 * @var string $treeSaveHash
 * @var string $treeRemoveHash
 * @var string $treeMoveHash
 * @var string $hideCssClass
 */

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

extract($params);
$session = Yii::$app->has('session') ? Yii::$app->session : null;

$resetTitle = Yii::t('kvtree', 'Reset');
$submitTitle = Yii::t('kvtree', 'Save');

// parse parent key
if ($node->isNewRecord) {
    $parentKey = empty($parentKey) ? '' : $parentKey;
} elseif (empty($parentKey)) {
    $parent = $node->parents(1)->one();
    $parentKey = empty($parent) ? '' : Html::getAttributeValue($parent, $keyAttribute);
}

/** @var Module $module */
$module = TreeView::module();

// node identifier
$id = $node->isNewRecord ? null : $node->$keyAttribute;
// breadcrumbs
if (array_key_exists('depth', $breadcrumbs) && $breadcrumbs['depth'] === null) {
    $breadcrumbs['depth'] = '';
} elseif (!empty($breadcrumbs['depth'])) {
    $breadcrumbs['depth'] = (string)$breadcrumbs['depth'];
}

// icons list
$icons = is_array($iconsList) ? array_values($iconsList) : $iconsList;


   /**
     * initialize for create or update
     */
    $depth = ArrayHelper::getValue($breadcrumbs, 'depth', '');
    $glue = ArrayHelper::getValue($breadcrumbs, 'glue', '');
    $activeCss = ArrayHelper::getValue($breadcrumbs, 'activeCss', '');
    $untitled = ArrayHelper::getValue($breadcrumbs, 'untitled', '');
    $name = $node->getBreadcrumbs($depth, $glue, $activeCss, $untitled);
    
//-------------------------custom breadcrums-----------------------------------------------------

$this->title =$node->name;
$parents = $node->parents()->all();

if(!empty($parents)){
    
   foreach($parents as $parent){
       
 $this->params['breadcrumbs'][] = ['label' =>$parent->name, 'url' => ['tblfolders/view2','id'=>$parent->id]];      
   } 
    
}


$this->params['breadcrumbs'][] = $this->title;
?>

<?php
/**
 * SECTION 3: Hash signatures to prevent data tampering. In case you are extending this and creating your own view, it
 * is mandatory to include this section below.
 */
 

?>

<?php // active form instance
$form = ActiveForm::begin(['action' => $formAction, 'options' => $formOptions]); ?>
<?= Html::hiddenInput('treeManageHash', $treeManageHash) ?>
<?= Html::hiddenInput('treeRemoveHash', $treeRemoveHash) ?>
<?= Html::hiddenInput('treeMoveHash', $treeMoveHash) ?>

<?php ActiveForm::end(); ?>


<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>

<?php if (!$node->isNewRecord || !empty($parentKey)): ?>

<?php

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




?>



<div class="card card-primary card-outline">
            <div class="card-header">
                
        <div class="kv-detail-crumbs"><?= $name ?></div>
    
        
              </div>  
              <!-- /.card-header -->
              <div class="card-body">
                
                   <?php
                  // helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use($hideCssClass) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
    }
    return Html::tag('div', '<div>' . $body . '</div>', ['class' => $class]);
};
                  ?>
                  
                   <?php
    /**
     * SECTION 5: Setup alert containers. Mandatory to set this up.
     */
    ?>
    <div class="kv-treeview-alerts">
        <?php
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        } else {
            echo $showAlert('success');
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        } else {
            echo $showAlert('danger');
        }
        echo $showAlert('warning');
        echo $showAlert('info');
        ?>
    </div>
                  
                  <?php
                  
  $btn_add_files = Html::a('<i class="fas fa-cloud-upload-alt"></i> Upload Files','#', [
                   'title' => 'Upload Files',
                  'data-toggle'=>'collapse', 
                  'data-target'=>'#fileUpload',
                  'class' => 'kv-action-button btn btn-outline-success ','data-container'=>'body'
                  
           ]);                
                  
$btn_add_doc = Html::a('<i class="fa fa-plus"></i> Add Document', Url::to(['tbldocuments/create', 'folderid' => $node->$keyAttribute]), [
                   'title' => 'Add Document',
                   'class' => 'kv-action-button btn  btn-outline-success  action-add-doc','data-toggle'=>"tooltip",'data-container'=>'body'
                  
           ]);
$btn_edit = Html::a('<i class="fas fa-edit"></i> Edit Folder', Url::to(['update', 'id' => $node->$keyAttribute]), [
                   'title' => 'Update',
                   'class' => 'kv-action-button btn btn-outline-success ','data-toggle'=>"tooltip",'data-container'=>'body'
           ]);
           
$btn_delete = Html::a('<i class="far fa-trash-alt"></i> Delete Folder', Url::to(['delete', 'id' => $node->$keyAttribute]), [
                   'title' => 'Delete',
                   'class' => 'kv-action-button btn btn-outline-success','data-toggle'=>"tooltip",'data-container'=>'body',
                    'data' => [
                       'confirm' => 'are you sure you want to delete this folder?',            
                       'method' => 'post',
                   ]
           ]);
           
$btn_access = Html::a('<i class="fas fa-user-lock"></i> Manage Access', Url::to(['delete', 'id' => $node->$keyAttribute]), [
                   'title' => 'Manage Access',
                   'class' => 'kv-action-button btn btn-outline-success ','data-toggle'=>"tooltip",'data-container'=>'body',
                   
           ]);
           
           
?>


           <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" 
                    href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"> <i class="fa fa-th-list"></i> Folder View</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" 
                    href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-user-lock"></i> Access Rights</a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" 
                    href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-cloud-upload-alt"></i> 
                    Upload Files</a>
                  </li>
                  
                </ul>
 <div class="tab-custom-content">
             
              <div class="btn-group mr-2">
   
   <?= $btn_add_files   ?>
    
  </div>
  <div class="btn-group mr-2" >
   <?=$btn_add_doc  ?> 
   
  </div>
  <div class="btn-group mr-2">
   <?=$btn_access ?>
  </div>
  
   <div class="btn-group" >
  <?=$btn_edit  ?>
  
  </div>
            </div>

<div class="tab-content" id="custom-tabs-one-tabContent">
   
    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
        
        <div id="fileUpload"  class="card  collapse">
              <div class="card-header">
                <h3 class="card-title">Fast Files Upload</h3>

                <div class="card-tools">
                 
                 
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php
echo FileInput::widget([
    'name' => 'files[]',
    'options'=>[
        'multiple'=>true
    ],
    'pluginOptions' => [
        'uploadUrl' => Url::to(['tblfolders/files-upload']),
        'uploadExtraData' => [
            'folderid' =>$node->$keyAttribute,
           
        ],
         'msgUploadBegin' => Yii::t('app', 'Please wait, system is uploading the files'),
                'msgUploadThreshold' => Yii::t('app', 'Please wait, system is uploading the files'),
                'msgUploadEnd' => Yii::t('app', 'Done'),
                'dropZoneClickTitle'=>'',
                "uploadAsync" => false,
                "browseOnZoneClick"=>true,
                 'fileActionSettings' => [
                    'showZoom' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                ],
        'maxFileCount' => 10
    ],'pluginEvents' => [
                'filebatchselected' => 'function() {
                 $(this).fileinput("upload");
                 }',



            ],
]);
?>
              </div>
              <!-- /.card-body -->
            </div>



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
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'fadeDelay'=>1000,
    'panel' => [
        'type' =>'default', 
        'heading' => '<h5><i class="fas fa-folder-open"></i> Folder Details</h5>',
       
    ],
    'deleteOptions'=>[ // your ajax delete parameters
        'params' => ['id' =>$node->$keyAttribute, 'kvdelete'=>true],
    ],
     'buttons1' =>'',
    'container' => ['id'=>'kv-demo'],
    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
]);
                  ?>
                  
                  
  </div>         
     </div>         
              
               
           
              
              <div class="row mt-3">
              
              <div class="col-12">
                  <h5>
                    <i class="fas fa-folder-open"></i> Folder Content
                   
                  </h5>
                </div>   
              <div class="col-12 table-responsive">
               
               
                <table class="table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Actions</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  
                  //-----------------first level node children-[folders]--------------------------
                  $child_folders = $node->children(1)->all();
                  
                   ?>
                   
                   <?php  if(!empty($child_folders)) :?>
                   
                   <?php foreach ($child_folders as $f) :?>
                   
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
                        
                      <?=Html::a('<i class="fas fa-pencil-alt"></i>',
                                              Url::to(["tblfolders/update",'id'=>$f->id,
                                           ])
                                          ,['class'=>'btn-outline-success btn-sm action-add-doc ','title'=>'Edit Folder','disabled'=>true] ); ?>|
                                           
                                                 <?=Html::a('<i class="far fa-trash-alt"></i>',
                                              Url::to(["tblfolders/delete",'id'=>$f->id
                                           ])
                                          ,['class'=>'btn-outline-danger btn-sm  action-delete','title'=>'Delete Folder','disabled'=>false] ); ?>   
                        
                        
                    </td>
                      
                    </tr>
                 
                  <?php endforeach;?> 
                  
              
                   <?php endif;?> 
                   
             <?php 
               
                  
                  //----------------------[documents]---------------------------------------------
                  $documents=Tbldocuments::find()->where(['folder'=>$node->$keyAttribute])->all();
                 
                   ?>      
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
                        
                      <?=Html::a('<i class="fas fa-pencil-alt"></i>',
                                              Url::to(["Tblfolders/update",'id'=>$doc->id,
                                           ])
                                          ,['class'=>'btn-outline-success  btn-sm  ','title'=>'Edit Folder','disabled'=>true] ); ?>|
                                           
                                                 <?=Html::a('<i class="far fa-trash-alt"></i>',
                                              Url::to(["Tblfolders/delete",'id'=>$doc->id
                                           ])
                                          ,['class'=>'btn-outline-danger btn-sm  action-delete','title'=>'Delete Folder','disabled'=>false] ); ?> 
                                          
                                          <?=Html::a($lock,
                                              Url::to(["Tblfolders/delete",'id'=>$doc->id
                                           ])
                                          ,['class'=>$btn_class,'title'=>$doc->status?'Check-In':'Check-Out','disabled'=>false] ); ?> 
                        
                        
                    </td>
                      
                    </tr>
                   
                   <?php endforeach;?>
                  
                 <?php endif; ?>
                 
                  </tbody>
                </table>
             </div>
             </div>
        
        </div>
   
   <div class="tab-pane fade access" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
       
       
       </div>
    
    </div>







            
            <?php else: ?>
    <?= $noNodesMessage ?>
<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>

<?php
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
            $content=$doc->getContent();
            $fa_icon=getIconByType(strtolower($content->fileType));
           
            
            $user=UserHelper::getUserInfo($doc->owner) ;
   
            $pos=UserHelper::getPositionInfo($doc->owner);
  
            $author=$user['first_name']." ".$user['last_name']." / ".$pos['position']; 
           
          
           //-------------------------------folder icon-----------------------------------------------
           echo Html::tag('div',Html::tag('i','',
           ['aria-hidden'=>true,'class'=>$fa_icon,'style'=>"color:#F2B02B"]),['class'=>'folder-img'])  ;
          
          //------------------------folder info------------------------------------------------------- 
           echo Html::tag('div',Html::a($content->orgFileName,['tbldocuments/view','id'=>$doc->id],
           ['class'=>'folder-title']).Html::tag('span','Author : '.
           Html::tag('span',$author,['style' => 'color:black;font-weight:500']).
           Html::tag('span','|',['style' => 'padding:0 8px 0 8px']).'Released Date : '.
           Html::tag('span',$doc->date,['style' => 'color:black;font-weight:500']).'</br>'.
         
           'Comment : '.$doc->comment,
           ['class'=>'folder-description'])
           ,['class'=>'folder-info'])  ; 
     
 }   
       
    
 }

?>


                  </div>
                  
                   </div>
                   
                   <?php


$script = <<< JS

 $('.action-add-doc').click(function () {
        var url = $(this).attr('href');
 
        
  
$('.modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('.modal-action #defaultModalLabel').text($(this).attr('title'));
return false;
                        
 
        });
        
    

JS;
$this->registerJs($script);

?>
