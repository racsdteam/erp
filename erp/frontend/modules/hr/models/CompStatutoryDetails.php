<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "comp_statutory_details".
 *
 * @property int $id
 * @property int $rama_pay
 * @property string $comp_rama_no
 * @property int $pension_pay
 * @property string $comp_pension_no
 */
class CompStatutoryDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comp_statutory_details';
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
            [['rama_pay', 'pension_pay'], 'integer'],
            [['comp_rama_no', 'comp_pension_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rama_pay' => 'Rama Pay',
            'comp_rama_no' => 'Rama No',
            'pension_pay' => 'Pension Pay',
            'comp_pension_no' => 'Pension No',
        ];
    }
}
