<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reception_goods".
 *
 * @property int $id
 * @property string $number
 * @property string $purchase_order_number
 * @property string $observation
 * @property int $procument_officer
 * @property string $upload
 * @property int $store_keeper
 * @property int $end_user_officer
 * @property string $timestamp
 */
class ReceptionGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
        public $uploaded_file;
        public $uploaded_file2;
         public $position1;
         public $position2;
         public $position3;
    public static function tableName()
    {
        return 'reception_goods';
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
            [['number', 'purchase_order_number','supplier',  'observation', 'reception_date', 'delivery_notes','store_keeper', 'end_user_officer'], 'required'],
            [[ 'supplier'], 'integer'],
            [['observation'], 'string'],
            [['number', 'purchase_order_number'], 'string', 'max' => 64],
             [['delivery_notes'], 'string', 'max' => 256],
             [['uploaded_file'], 'file'],
             [['uploaded_file2'], 'file'],
            
             ['uploaded_file2', 'required',
                'when' => function ($model) {
                    return false;
                },
                'whenClient' => "function (attribute, value) {    
              return ($('.field-receptiongoods-uploaded_file2 .file-input .kv-file-content').find('embed').length == 0 );
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'purchase_order_number' => 'Purchase Order Number',
            'observation' => 'Observation',
            'upload' => 'Upload',
            'supplier' => 'Supplier',
            'store_keeper' => 'Store Keeper',
            'reception_date' => 'Reception Date ',
            'end_user_officer' => 'End User Officer',
            'timestamp' => 'Timestamp',
        ];
    }
}
