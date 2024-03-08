<?php

use kartik\tree\TreeView;
use common\models\Tblfolders;
?>


<?php
$user=Yii::$app->user->identity;

      
echo \kartik\tree\TreeView::widget([
'query' =>Tblfolders::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'RAC DMS'],
    'rootOptions' => ['label'=>'<span class="text-warning">RAC DMS</span>'],
    'topRootAsHeading' =>true, // this will override the headingOptions
    'fontAwesome' => true,
    'isAdmin' => $user->isAdmin(),
    'bsVersion'=>4,
    'displayValue' =>1,
    'iconEditSettings'=> [
        'show' => 'list',
        'listData' => [
            'folder' => 'Folder',
            'file' => 'File',
            'mobile' => 'Phone',
            'bell' => 'Bell',
        ]
    ],
     'allowNewRoots'=> $user->isAdmin(),
    'toolbar'=>[
     TreeView::BTN_REMOVE => [
        'alwaysDisabled' => !$user->isAdmin(),
    ],
    TreeView::BTN_MOVE_UP => [
        'alwaysDisabled' => !$user->isAdmin(),
    ],
    TreeView::BTN_MOVE_DOWN => [
        'alwaysDisabled' => !$user->isAdmin(),
    ],
    TreeView::BTN_MOVE_LEFT => [
        'alwaysDisabled' => !$user->isAdmin(),
    ],
    TreeView::BTN_MOVE_RIGHT => [
        'alwaysDisabled' => !$user->isAdmin(),
    ]],
    'softDelete' => false,
    'cacheSettings' => ['enableCache' =>false],
   
    'clientMessages'=>[
   
    'invalidCreateNode' => Yii::t('kvtree', 'Cannot create folder. Parent folder is not saved or is invalid.'),
    'emptyNode' => Yii::t('kvtree', '(new)'),
    'removeNode' => Yii::t('kvtree', 'Are you sure you want to remove this folder?'),
    'nodeRemoved' => Yii::t('kvtree', 'The folder was removed successfully.'),
    'nodeRemoveError' => Yii::t('kvtree', 'Error while removing the folder. Please try again later.'),
    'nodeNewMove' => Yii::t('kvtree', 'Cannot move this folder as the node details are not saved yet.'),
    'nodeTop' => Yii::t('kvtree', 'Already at top-most folder in the hierarchy.'),
    'nodeBottom' => Yii::t('kvtree', 'Already at bottom-most folder in the hierarchy.'),
    'nodeLeft' => Yii::t('kvtree', 'Already at left-most folder in the hierarchy.'),
    'nodeRight' => Yii::t('kvtree', 'Already at right-most folder in the hierarchy.'),
    'emptyNodeRemoved' => Yii::t('kvtree', 'The untitled folder was removed.'),
    'selectNode' => Yii::t('kvtree', 'Select a folder by clicking on one of the tree items.'),
   
        ],
    //'nodeViewButtonLabels'=>[]
	])
	
?>