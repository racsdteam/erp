<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_supporting_doc_type".
 *
 * @property int $id
 * @property string $type
 */
class ErpMemoSupportingDocType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_supporting_doc_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }
}
