<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "comp_banks".
 *
 * @property int $id
 * @property string $name
 * @property string $acc_no
 * @property string $branch
 */
class CompBanks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comp_banks';
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
            [['name', 'acc_no'], 'required'],
            [['name', 'acc_no', 'branch'], 'string', 'max' => 255],
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
            'acc_no' => 'Acc No',
            'branch' => 'Branch',
        ];
    }
}
