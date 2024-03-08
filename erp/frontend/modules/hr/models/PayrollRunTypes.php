<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payroll_run_types".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $display_order
 */
class PayrollRunTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_run_types';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'description'], 'required'],
            [['description'], 'string'],
            [['display_order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'display_order' => 'Display Order',
        ];
    }
}
