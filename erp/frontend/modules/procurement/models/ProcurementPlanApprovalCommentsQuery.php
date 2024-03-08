<?php

namespace frontend\modules\procurement\models;

/**
 * This is the ActiveQuery class for [[PayrollApprovalComments]].
 *
 * @see PayrollApprovalComments
 */
class ProcurementPlanApprovalCommentsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PayrollApprovalComments[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PayrollApprovalComments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
