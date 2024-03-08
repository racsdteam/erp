<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_categ".
 *
 * @property int $id
 * @property string $categ
 */
class ErpMemoCateg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_categ';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categ'], 'required'],
            [['categ','categ_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categ' => 'Categ',
        ];
    }
}
