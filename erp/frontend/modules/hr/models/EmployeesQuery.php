<?php

namespace frontend\modules\hr\models;


/**
 * This is the ActiveQuery class for [[PayItems]].
 *
 * @see PayItems
 */
class EmployeesQuery extends \yii\db\ActiveQuery
{
    public const TBL_NAME='employees';
    
    public function active()
    {
        return $this->andWhere(['status'=>EmployeeStatuses::STATUS_TYPE_ACT]);
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
