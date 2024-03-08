
<?php

use yii\bootstrap4\ActiveForm;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

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
<?php
/**
 * SECTION 1: Initialize node view params & setup helper methods.
 */
?>


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
 $formOptions['class']='needs-validation';
 $formOptions['novalidate']='';
// active form instance
$form = ActiveForm::begin(['action' => $formAction, 'options' => $formOptions,
'enableClientValidation'=>true,
                               
                               'enableAjaxValidation' => false,
'fieldConfig' => [
        'errorOptions' => ['class' => 'invalid-feedback']
    ],]);
    
    

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use($hideCssClass) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
    }
    return Html::tag('div', '<div>' . $body . '</div>', ['class' => $class]);
};


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

?>

<?php
/**
 * SECTION 2: Initialize hidden attributes. In case you are extending this and creating your own view, it is mandatory
 * to set all these hidden inputs as defined below.
 */
?>
<?= Html::hiddenInput('nodeTitle', $nodeTitle) ?>
<?= Html::hiddenInput('nodeTitlePlural', $nodeTitlePlural) ?>
<?= Html::hiddenInput('treeNodeModify', $node->isNewRecord) ?>
<?= Html::hiddenInput('parentKey', $parentKey) ?>
<?= Html::hiddenInput('currUrl', $currUrl) ?>
<?= Html::hiddenInput('modelClass', $modelClass) ?>
<?= Html::hiddenInput('nodeSelected', $nodeSelected) ?>


<?php
/**
 * SECTION 3: Hash signatures to prevent data tampering. In case you are extending this and creating your own view, it
 * is mandatory to include this section below.
 */
?>
<?= Html::hiddenInput('treeManageHash', $treeManageHash) ?>
<?= Html::hiddenInput('treeRemoveHash', $treeRemoveHash) ?>
<?= Html::hiddenInput('treeMoveHash', $treeMoveHash) ?>


<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>

<?php if (!$node->isNewRecord || !empty($parentKey)): ?>



<?php

 

/**
     * initialize for create or update
     */
    $depth = ArrayHelper::getValue($breadcrumbs, 'depth', '');
    $glue = ArrayHelper::getValue($breadcrumbs, 'glue', '');
    $activeCss = ArrayHelper::getValue($breadcrumbs, 'activeCss', '');
    $untitled = ArrayHelper::getValue($breadcrumbs, 'untitled', '');
    $name = $node->getBreadcrumbs($depth, $glue, $activeCss, $untitled);
    
   
   
    if ($node->isNewRecord && !empty($parentKey) && $parentKey !== TreeView::ROOT_KEY) {
        /**
         * @var Tree $modelClass
         * @var Tree $parent
         */
        if (empty($depth)) {
            $depth = null;
        }
        if ($depth === null || $depth > 0) {
            $parent = $modelClass::findOne($parentKey);
            $name = $parent->getBreadcrumbs($depth, $glue, null) . $glue . $name;
        }
    }
?>


<?php endif; ?>


<div class="card m-card">
            <div class="card-header">
                
        <div class="kv-detail-crumbs"><?= $name ?></div>
       
        
              </div>  
              <!-- /.card-header -->
              <div class="card-body">
                 
                 
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
     * the primary key input field
     */
    if ($showIDAttribute) {
        $options = ['readonly' => true];
        if ($node->isNewRecord) {
            $options['value'] = Yii::t('kvtree', '(new)');
        }
        echo  $form->field($node, $keyAttribute)->textInput($options);
    } else {
        echo Html::activeHiddenInput($node, $keyAttribute);
    }
   ?>
  
   <?= $form->field($node, $nameAttribute)->textInput()?>
   <div class="form-group highlight-addon field-Tblfolders-icon">
<label class="has-star pt-0">Icon</label>

<input type="hidden" name="Tblfolders[icon]" value="">
<div id="Tblfolders-icon" class="form-control" style="height:135px; overflow-y:auto" role="radiogroup">
<div class="custom-control custom-radio">
    <input type="radio" id="Tblfolders-icon--0" class="custom-control-input" name="Tblfolders[icon]" value=""  data-index="0" labeloptions="{&quot;class&quot;:&quot;custom-control-label&quot;}"><label class="custom-control-label" for="Tblfolders-icon--0"><em>Default</em> ( <span class="text-warning kv-node-icon kv-icon-parent"><i class="fas fa-folder kv-node-closed"></i></span> / <span class="text-warning kv-node-icon kv-icon-parent"><i class="fas fa-folder-open kv-node-opened"></i></span> / <span class="text-info kv-node-icon kv-icon-child"><i class="fas fa-file"></i></span>)</label></div>
<div class="custom-control custom-radio">
    <input type="radio" id="Tblfolders-icon--1" class="custom-control-input" name="Tblfolders[icon]" value="folder" checked="" data-index="1" labeloptions="{&quot;class&quot;:&quot;custom-control-label&quot;}"><label class="custom-control-label" for="Tblfolders-icon--1"><span class="fas fa-folder"></span> Folder</label></div>
<div class="custom-control custom-radio">
    <input type="radio" id="Tblfolders-icon--2" class="custom-control-input" name="Tblfolders[icon]" value="file" data-index="2" labeloptions="{&quot;class&quot;:&quot;custom-control-label&quot;}"><label class="custom-control-label" for="Tblfolders-icon--2"><span class="fas fa-file"></span> File</label></div>


</div>
   <?= $form->field($node, 'comment')->textarea(['rows' => 6,'placeholder'=>'comment...']) ?>
   <?= Html::submitButton(
                    ArrayHelper::getValue($nodeViewButtonLabels, 'submit', $submitTitle),
                    ['class' => 'btn btn-primary', 'title' => $submitTitle]
                ) ?> 
    
    
                  </div>
                  
                   </div>
                   
                   <?php ActiveForm::end(); ?>
                   
                   <?php
                   
                   
                   
                   $script = <<< JS
   
JS;
$this->registerJs($script);

?>
