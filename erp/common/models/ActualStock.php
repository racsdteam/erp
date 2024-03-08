<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "actual_stock".
 *
 * @property int $it_id
 * @property string $it_code
 * @property string $it_name
 * @property string $it_tech_specs
 * @property int $it_min
 * @property string $it_unit
 * @property string $it_categ
 * @property string $actual_stock
 */
class ActualStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actual_stock';
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
            [['it_id', 'it_min'], 'integer'],
            [['it_code', 'it_name', 'it_tech_specs', 'it_min', 'it_unit', 'it_categ'], 'required'],
            [['it_tech_specs'], 'string'],
            [['actual_stock'], 'number'],
            [['it_code'], 'string', 'max' => 20],
            [['it_name'], 'string', 'max' => 50],
            [['it_unit'], 'string', 'max' => 64],
            [['it_categ'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'it_id' => 'It ID',
            'it_code' => 'It Code',
            'it_name' => 'It Name',
            'it_tech_specs' => 'It Tech Specs',
            'it_min' => 'It Min',
            'it_unit' => 'It Unit',
            'it_categ' => 'It Categ',
            'actual_stock' => 'Actual Stock',
        ];
    }
}
