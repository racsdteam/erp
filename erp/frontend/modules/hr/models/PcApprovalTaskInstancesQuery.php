<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[PcApprovalTaskInstances]].
 *
 * @see PcApprovalTaskInstances
 */
class PcApprovalTaskInstancesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PayrollApprovalTaskInstances[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PayrollApprovalTaskInstances|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
