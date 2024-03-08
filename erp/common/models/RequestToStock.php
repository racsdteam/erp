<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request_to_stock".
 *
 * @property int $reqtostock_id
 * @property int $it_id
 * @property int $inst_id
 * @property int $serv_id
 * @property int $staff_id
 * @property int $supervisor
 * @property int $req_qty
 * @property string $exp_rec_date
 * @property string $req_desc
 * @property string $status
 * @property string $aprval_date
 * @property string $timestamp
 */
class RequestToStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public $category;  
    public $subcategory;
    public static function tableName()
    {
        return 'request_to_stock';
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
            [['staff_id'], 'required'],
            [['staff_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

            'staff_id' => 'Staff ID',
        ];
    }
}
