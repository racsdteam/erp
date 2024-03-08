<?php

use yii\helpers\Html;
use frontend\assets\AdminLte3Asset;
AdminLte3Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    
    <head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
     <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/logo.png" type="image/x-icon" />
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <?php $this->head() ?>
    
    </head>



<body  class="hold-transition login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
