<?php

namespace frontend\modules\hr\models;


/**
 * This is the ActiveQuery class for [[PayItems]].
 *
 * @see PayItems
 */
class PayGroupsQuery extends \yii\db\ActiveQuery
{
    public const TBL_NAME='pay_groups';
    
    public function active()
    {
        return $this->andWhere(['active'=>1]);
    }
    
     public function regular()
    {
        return $this->andWhere(['run_type'=>'REG']);
    }
    
     public function suppl()
    {
        return $this->andWhere(['run_type'=>'SUP']);
    }
   
 
   
    /**
     * {@inheritdoc}
     * @return PayItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PayItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
   
}
