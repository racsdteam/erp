<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "envelope_settting".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $enveloppe_code
 * @property string $procurement_categories_code
 * @property string $procurment_methode_code
 * @property int $user_id
 * @property string $timestamp
 */
class EnvelopeSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'envelope_settting';
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
            [['name', 'code', 'procurement_categories_code', 'procurement_methods_code', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 1000],
            [['code'], 'string', 'max' => 8],
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
            'procurement_categories_code' => 'Procurement Categories Code',
            'procurement_methods_code' => 'Procurement Methods Code',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
