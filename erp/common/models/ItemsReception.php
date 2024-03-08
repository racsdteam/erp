<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items_reception".
 *
 * @property int $id
 * @property int $item
 * @property int $item_qty
 * @property double $item_unit_price
 * @property string $item_currency
 * @property double $total_price
 * @property string $vat_included
 * @property string $total_currency
 * @property int $staff_id
 * @property string $dfile
 * @property string $itm_desc
 * @property string $recv_date
 * @property string $timestamp
 */
class ItemsReception extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_reception';
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
            [['item', 'item_qty_ordered','item_qty', 'reception_good','item_unit_price',  'total_price', 'vat_included', 'total_currency', 'staff_id',], 'required'],
            [['reception_good', 'staff_id','item'], 'integer'],
            [['item_qty_ordered','item_qty'],'number'],
            [['item_unit_price', 'total_price'], 'number'],
            [['total_currency'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item' => 'Item',
            'item_qty' => 'Item Qty',
            'item_unit_price' => 'Item Unit Price',
            'item_currency' => 'Item Currency',
            'total_price' => 'Total Price',
            'vat_included' => 'Vat Included',
            'total_currency' => 'Total Currency',
            'staff_id' => 'Staff ID',
            'itm_desc' => 'Itm Desc',
            'timestamp' => 'Timestamp',
        ];
    }
}
