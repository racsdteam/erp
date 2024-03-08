<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[CompJobRoles]].
 *
 * @see CompJobRoles
 */
class CompJobRolesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompJobRoles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompJobRoles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
