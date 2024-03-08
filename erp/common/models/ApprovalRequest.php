<?php
    namespace common\models;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\base\Model;
    use common\models\User;
     
    /**
     * Change password form for current user only
     */
    class ApprovalRequest extends Model
    {
        public $entityRecord;
        public $initiator;
        public $comment;
        public $wf;
     
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
               
                [['entityRecord','initiator','wf'], 'integer'],
                [['comment'], 'string'],
               
            ];
        }
       public function attributeLabels()
    {
        return [
            'entityRecord' => 'Entity Record',
            'initiator'=>'Submitter',
            'comment' => 'Comment',
            'wf'=>'Approval Workflow'
           
           
            
        ];
    }
        
    }