<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->context->layout='login';
$this->title = 'User Feeback';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row clearfix">

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12  col-md-offset-2">

<div style="margin-top:100px;" class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Message</h3>
 </div>
 <div class="box-body">

 <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Message!</h4>
               wait for your supervisor to grant you access!
              </div>

 </div>

 </div>
 
 
 </div>

</div>
