
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
use kartik\tabs\TabsX;


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
  .kv-detail-container{
      
     padding: 0 !important;
     margin:0 !important;
     background:white;
  } 
  
  
    
</style>


<?php
  $defaults = [
            'modelClass' => '',
            'hideCssClass' => '',
            'defaultBtnCss' => '',
            'formAction' => '',
            'currUrl' => '',
            'nodeView' => '',
            'nodeSelected' => '',
            'nodeTitle' => $nodeTitles['node'],
            'nodeTitlePlural' => $nodeTitles['nodes'],
            'noNodesMessage' => '',
            'isAdmin' => false,
            'softDelete' => true,
            'showFormButtons' => true,
            'showIDAttribute' => true,
            'showNameAttribute' => true,
            'allowNewRoots' => true,
            'formOptions' => [],
            'nodeAddlViews' => [],
            'nodeViewButtonLabels' => [],
            'nodeViewParams' => '',
            'icons' => [],
            'iconsListShow' => 'text',
            'iconsList' => [],
            'breadcrumbs' => [],
        ];
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

<div class="card card-warning card-outline">
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
    /**
     * Node content Display
     */
    ?>  
    
    <?php
    //------------------file uploads---------------------------------------
      $currentUser=Yii::$app->user->identity;
      $items=array();

     if($node->getAccessMode($currentUser)>=2){
         
         
         
         
        $items[]= [
        'label'=>'<i class="fas fa-layer-group"></i> Folder View' ,
        'content'=>$content,
        'active'=>$active,
        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/racdms/tblfolders/get-content','id'=>$node->$keyAttribute])]
    ];   
         
     }
   
    if($node->getAccessMode($currentUser)>=3){
       
       $items[]= [
        'label'=>'<i class="fas fa-cloud-upload-alt"></i> Upload Files' ,
        'content'=>$this->render('_upload-files', ['node'=>$node]),
        
    ]; 
    
        
        
    }
    
      if($node->getAccessMode($currentUser)>=3){
          
         $items[]= [
        'label'=>'<i class="fas fa-plus-circle"></i> Add Document' ,
        'content'=>$content1,
        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/racdms/tbldocuments/create','folderid' => $node->$keyAttribute])]
        
    ];   
          
      }
    
     
      if($node->getAccessMode($currentUser)>=4){
          
         $items[]= [
        'label'=>'<i class="fas fa-user-lock"></i> Manage Permissions' ,
        'content'=>$content2,
        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/racdms/tblfolders/manage-access','id'=>$node->$keyAttribute])]
        
    ];  
          
          
      }
    
    
    
     
            
          echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false,
    'bsVersion'=>4,
    'pluginOptions'=>['enableCache'=>false
        
        ]
]);
            
    
    ?>
    
    
     <?php
    /**
     * End node content Display
     */
    ?>
            
            <?php else: ?>
    <?= $noNodesMessage ?>
<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>



                  </div>
                  
                   </div>
       
       <?php 
       
       $data=array();
      
      
       
       if(!empty($params)){
           
           foreach($defaults as $key=>$val){
           
            $data[$key]=isset($params[$key])?$params[$key]:$val;   
           
           }
       }
       $data['parentKey']=$parentKey;
       $data['treeManageHash']=$treeManageHash;
       $data['treeRemoveHash']=$treeRemoveHash;
       $data['treeMoveHash']=$treeMoveHash;
      
    
       ?>            
                   
 
                   
                   
                   <?php
//---------------convert to js Object ------------------------------
$data=json_encode($data);

$script = <<< JS

$(function() {
   
setTimeout(function() {
$(".tabs-krajee").find("li a.active").click();
},10);  
   
   
$('.action-update-doc').click(function () {
        var url = $(this).attr('href');
 
        
  
$('.modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('.modal-action #defaultModalLabel').text($(this).attr('title'));
return false;
                        
 
        });
        
 

    
 $('div.tabs-x').on('tabsX:success', function (event, data, status, jqXHR) {
 


$('.table  tbody').on('click', '.action-delete-doc', function () {
   
var url = $(this).attr('href'); 

   Swal.fire({
 title: "Are you sure?",
  text: "Document will deleted !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
 
  $.post( url, function(res ) {
 
    var response=res.out;
     var status=res.status;
     
    if(status!=='error'){
          
          Swal.fire(
      'Deleted!',
     'document has been deleted!',
      'success'
    )
     location.reload();
          
      }else{
       
       Swal.fire(
      'Error!',
       response,
      'error'
    )
      }
      
      
  });
  
      
      
  }
})
 
return false;
 
}); 




















 var update_links=document.querySelectorAll(".action-update-content");
 var update_doc_links=document.querySelectorAll(".action-update-doc");

 
 for (i = 0; i < update_links.length; ++i) {
 
  update_links[i].onclick=function(e) {
    
    e.preventDefault();
    
    var url = $(this).attr('href');
    var id=getUrlVars(url)["id"];
   
    var title=$(this).attr('title');
    
      var data=$data;
      data.id=id;
   $('.modal-action #defaultModalLabel').text(title);
   $('.modal-action').modal('show'); 
    $.ajax({
        type: "POST",
        url: url,
        data:data,
        dataType: 'json',
        success: function(res) {
        
        var data= res.out;
       
        $('.modal-action').find('.modal-body').html(data);
        
        

      
        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
};
}

for (i = 0; i < update_doc_links.length; ++i) {
 
  update_doc_links[i].onclick=function(e) {
    
    e.preventDefault();
   var url = $(this).attr('href')+'?target=1';
  
   $('.modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('.modal-action #defaultModalLabel').text($(this).attr('title'));
   
   return false;
  
};
}
 

 
});//==================end of tab load event===============================    
  
});

 
function getUrlVars(url) {
    var vars = {};
    var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}        
    

JS;
$this->registerJs($script);

?>
