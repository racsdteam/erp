<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_annotations".
 *
 * @property int $id
 * @property int $doc
 * @property string $annotation
 * @property int $author
 * @property string $timestamp
 */
class ErpDocumentAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_annotations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc', 'annotation', 'author'], 'required'],
            [['doc', 'author'], 'integer'],
            [['annotation'], 'string'],
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
            'doc' => 'Doc',
            'annotation' => 'Annotation',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
        ];
    }
}
