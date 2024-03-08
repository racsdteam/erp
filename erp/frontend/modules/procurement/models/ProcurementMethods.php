<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_methods".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 *
 * @property ProcurementActivities[] $procurementActivities
 */
class ProcurementMethods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_methods';
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
            [['name', 'code'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
            [['code'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcurementActivities()
    {
        return $this->hasMany(ProcurementActivities::className(), ['procurement_method' => 'code']);
    }
}
