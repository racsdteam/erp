<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "itemlist".
 *
 * @property int $it_id
 * @property string $it_code
 * @property string $it_name
 * @property string $it_techspecs
 * @property int $it_minsto
 * @property string $it_minstounit
 * @property string $it_categ
 *
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     
     public $it_categ;
     
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['it_code', 'it_name', 'it_tech_specs','it_min', 'it_unit', 'it_sub_categ'], 'required'],
            [['it_min'], 'integer'],
            [['it_code'], 'string', 'max' => 64],
            [['it_name'], 'string', 'max' => 255],
            [['it_tech_specs'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'it_id' => 'Item ID',
            'it_code' => 'Item Code',
            'it_name' => 'Item Name',
            'it_tech_specs' => 'Item Tech Specs',
            'it_min' => 'Item Minimun',
            'it_unit' => 'Item Unit',
            'subcategories.name' => 'Sub-Category',
             'subcategories.categories.name' => 'Category',
        ];
    }
    public function getSubcategories()
 {
        return $this->hasOne(SubCategories::className(), ['id' => 'it_sub_categ']);
 }
}
