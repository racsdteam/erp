<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "Lots_categories".
 *
 * @property int $id
 * @property string $categ_name
 * @property string $categ_code
 */
class LotsCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lots_categories';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db5');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categ_name', 'categ_code'], 'required'],
            [['categ_name', 'categ_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categ_name' => 'Category Name',
            'categ_code' => 'Category Code',
        ];
    }
}
