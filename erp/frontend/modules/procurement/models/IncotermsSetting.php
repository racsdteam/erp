<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "incoterms_setting".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $user_id
 * @property string $timestamp
 */
class IncotermsSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incoterms_settings';
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
            [['name', 'code', 'description', 'user_id'], 'required'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['timestamp'], 'safe'],
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
            'description' => 'Description',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
