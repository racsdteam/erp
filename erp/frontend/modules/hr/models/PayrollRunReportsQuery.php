<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[PayrollRunReports]].
 *
 * @see PayrollRunReports
 */
class PayrollRunReportsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PayrollRunReports[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PayrollRunReports|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
