<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use adminlte\widgets\Menu;
use common\models\UserHelper;

use yii\helpers\Url;
use common\models\User;
$user=Yii::$app->user->identity; 

 $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
  $userposition=$userinfo['position_code'];
  
  
?>
<?php $this->beginContent('@common/views/layouts/base.php') ?>


 
  <?php $this->beginBlock('sidebar-menu') ?>
  
  <?php
  $this->params['sidemenu'] = 1; 
  $items=[
        ['label' => 'Menu', 'options' => ['class' => 'header']],
        ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard',
         'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC"  || $userposition == "ITENG",
            'url' => ['default/index'], 'active' => $this->context->route == 'user/default/index',
           
        ],
        
//-----------------------------------------manage Item Categories---------------------------------------------------------
[
    'label' => 'Items Categories',
    'icon' => 'fa fa-building-o',
    'url' => '#',
    'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC" || $userposition == "ITENG" ,
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Create It. category',
    'icon' => 'fa fa-plus',
    'url' =>Url::to(['/logistic/categories/create']),
    'active' => $this->context->route == 'logistic/categories/create'
    ],
     [
    'label' => 'All It. categories ',
    'icon' => 'fa fa-eye ',
    'url' => Url::to(['/logistic/categories/index']),
    'active' => $this->context->route == 'logistic/categories/index'
    ],
    ]
    ],
//-----------------------------------------manage Item Sub Categories---------------------------------------------------------
[
    'label' => 'Items Sub-Categories',
    'icon' => 'fa fa-building-o',
    'url' => '#',
    'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC"  || $userposition == "ITENG",
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Create It. Sub Category',
    'icon' => 'fa fa-plus',
    'url' =>Url::to(['/logistic/sub-categories/create']),
    'active' => $this->context->route == 'logistic/sub-categories/create'
    ],
     [
    'label' => 'All It. Sub Categories ',
    'icon' => 'fa fa-eye ',
    'url' => Url::to(['/logistic/sub-categories/index']),
    'active' => $this->context->route == 'logistic/sub-categories/index'
    ],
    ]
    ],
//-----------------------------------------manage Supplier---------------------------------------------------------
[
    'label' => 'Supplier Registry',
    'icon' => 'fa fa-building-o',
    'url' => '#',
    'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC"  || $userposition == "ITENG",
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Create Supplier',
    'icon' => 'fa fa-plus',
    'url' =>Url::to(['/logistic/supplier/create']),
    'active' => $this->context->route == 'logistic/supplier/create'
    ],
     [
    'label' => 'All Suppliers ',
    'icon' => 'fa fa-eye ',
    'url' => Url::to(['/logistic/supplier/index']),
    'active' => $this->context->route == 'logistic/supplier/index'
    ],
    ]
    ],
//-----------------------------------------manage Item---------------------------------------------------------
[
    'label' => 'Item Registry',
    'icon' => 'fa fa-list-alt',
    'url' => '#',
    'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC"  || $userposition == "ITENG",
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Create Item',
    'icon' => 'fa fa-plus',
    'url' =>Url::to(['/logistic/items/create']),
    'active' => $this->context->route == 'logistic/items/create'
    ],
    
       [
    'label' => 'All Items ',
    'icon' => 'fa fa-eye ',
    'url' => Url::to(['/logistic/items/index']),
    'active' => $this->context->route == 'logistic/items/index'
    ],
    ]
    ],

//-----------------------------------------manage Goods Received---------------------------------------------------------
[
    'label' => 'Goods Received Notes',
    'icon' => 'fa fa-shopping-cart',
    'url' => '#',
     'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC"  || $userposition == "ITENG",
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Create GRN',
    'icon' => 'fa fa-edit',
    'url' =>Url::to(['/logistic/reception-goods/create']),
    'active' => $this->context->route == 'logistic/reception-goods/create'
    ],
    [
    'label' => 'Draft GRN ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/reception-goods/draft']),
    'active' => $this->context->route == 'logistic/reception-goods/draft'
    ],
     [
    'label' => 'Pending GRN ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/reception-goods/pending']),
    'active' => $this->context->route == 'logistic/reception-goods/pending'
    ],
   [
    'label' => 'Approved GRN ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/reception-goods/approved']),
    'active' => $this->context->route == 'logistic/reception-goods/approved'
    ],
       [
    'label' => 'All GRN ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/reception-goods/index']),
    'active' => $this->context->route == 'logistic/reception-goods/index'
    ],
    ]
    ],
   
   
   //-----------------------------------------manage Stock Voucher---------------------------------------------------------
[
    'label' => 'Stock Voucher',
    'icon' => 'fa fa-shopping-cart',
    'url' => '#',
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Create Voucher',
    'icon' => 'fa fa-edit',
    'url' =>Url::to(['/logistic/request-to-stock/create']),
    'active' => $this->context->route == 'logistic/request-to-stock/create'
    ],
    [
    'label' => 'Draft Vouchers ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/request-to-stock/draft']),
    'active' => $this->context->route == 'logistic/request-to-stock/draft'
    ],
     [
    'label' => 'Pending Vouchers ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/request-to-stock/pending']),
    'active' => $this->context->route == 'logistic/request-to-stock/pending'
    ],
      [
    'label' => 'My Vouchers ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/request-to-stock/my-vouchers']),
    'active' => $this->context->route == 'logistic/request-to-stock/my-vouchers'
    ],
   [
    'label' => 'Approved Vouchers ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/request-to-stock/approved']),
    'active' => $this->context->route == 'logistic/request-to-stock/approved'
    ],
       [
    'label' => 'All Vouchers ',
    'icon' => 'fa fa-shopping-cart',
    'url' => Url::to(['/logistic/request-to-stock/index']),
    'active' => $this->context->route == 'logistic/request-to-stock/index'
    ],
    ]
    ],
    
     //-----------------------------------------Reports---------------------------------------------------------
[
    'label' => 'Reports',
    'icon' => 'fa fa-file',
    'url' => '#',
     'visible'=>$userposition == "MGRLGX" || $userposition == "STOFC"  || $userposition == "ITENG",
    'options'=>['class'=>'treeview'],
    'items' => [
    [
    'label' => 'Actual Stock',
    'icon' => 'fa fa-file',
    'url' =>Url::to(['/logistic/reports/actual-stock']),
    'active' => $this->context->route == 'logistic/reports/actual-stock'
    ],
    [
    'label' => 'Item history ',
    'icon' => 'fa fa-file',
    'url' => Url::to(['/logistic/reports/item-history']),
    'active' => $this->context->route == 'logistic/reports/item-history'
    ],
     [
    'label' => 'Received Items',
    'icon' => 'fa fa-file',
    'url' => Url::to(['/logistic/reports/received']),
    'active' => $this->context->route == 'logistic/reports/received'
    ],
   [
    'label' => 'Distributed Items',
    'icon' => 'fa fa-file',
    'url' => Url::to(['/logistic/reports/distributed']),
    'active' => $this->context->route == 'logistic/reports/distributed'
    ],

    ]
    ],  
    
    
    
    ]
      
      ?>
      <?=
        Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree','data-widget'=>'tree'],
                    'items' =>$items,'encodeLabels' => false//to be able to display badge 
                ]
        )
        ?>
 
 <?php $this->endBlock() ?>
 
 <?= $content ?>

<?php $this->endContent() ?>

 

