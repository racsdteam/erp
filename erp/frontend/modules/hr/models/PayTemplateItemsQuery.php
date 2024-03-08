<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[EmpAddress]].
 *
 * @see EmpAddress
 */
class PayTemplateItemsQuery extends \yii\db\ActiveQuery
{
    // conditions appended by default (can be skipped)
    /*public function init()
    {
        $this->andOnCondition(['active' =>1]);
        parent::init();
    }*/

    // ... add customized query methods here ...

    public function earnings()
    {
        return $this->andOnCondition(['item_categ' =>PayItemCategories::CAT_E]);
    }
    
     // ... add customized query methods here ...

    public function deductions()
    {
        return $this->andOnCondition(['or',['item_categ' =>PayItemCategories::CAT_D],['item_categ' =>PayItemCategories::CAT_SD]]);
    }
}
