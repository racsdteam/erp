<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_flow".
 *
 * @property int $id
 * @property int $document
 * @property int $creator
 * @property string $timestamp
 */
class ErpDocumentFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document', 'creator'], 'required'],
            [['document', 'creator'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document' => 'Document',
            'creator' => 'Creator',
            'timestamp' => 'Timestamp',
        ];
    }
}
