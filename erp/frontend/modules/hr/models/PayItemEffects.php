<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pay_item_effects".
 *
 * @property int $id
 * @property string $effect_name
 * @property string $effect_code
 */
class PayItemEffects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_item_effects';
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
            [['effect_name', 'effect_code'], 'required'],
            [['effect_name'], 'string', 'max' => 255],
            [['effect_code'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'effect_name' => 'Effect Name',
            'effect_code' => 'Effect Code',
        ];
    }
}
