<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_comment".
 *
 * @property int $id
 * @property string $remark
 * @property int $document
 * @property string $timestamp
 * @property int $author
 */
class ErpDocumentRemark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_remark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remark', 'document', 'author'], 'required'],
            [['remark'], 'string'],
            [['document', 'author'], 'integer'],
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
            'comment' => 'Comment',
            'document' => 'Document',
            'timestamp' => 'Timestamp',
            'user' => 'User',
        ];
    }
}
