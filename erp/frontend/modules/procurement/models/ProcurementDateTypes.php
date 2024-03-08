<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_date_types".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $report_name
 * @property string $description
 */
class ProcurementDateTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_date_types';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'report_name'], 'required'],
            [['description'], 'string'],
            [['active'], 'integer'],
            [['code'], 'string', 'max' => 11],
            [['name', 'report_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'report_name' => 'Report Name',
            'description' => 'Description',
        ];
    }
}
