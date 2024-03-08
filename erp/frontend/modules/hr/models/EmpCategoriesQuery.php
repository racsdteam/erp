<?php

namespace frontend\modules\hr\models;

/**
 * This is the ActiveQuery class for [[EmpCategories]].
 *
 * @see EmpCategories
 */
class EmpCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmpCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmpCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
