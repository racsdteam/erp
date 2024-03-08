<?php

namespace frontend\modules\procurement;

/**
 * procurement module definition class
 */
class Procurement extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\procurement\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';

        // custom initialization code goes here
    }
}
