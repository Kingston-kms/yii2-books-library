<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $send_to
 * @property string $name
 * @property string|null $message
 * @property string|null $phone
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                TimestampBehavior::class
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['send_to', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['send_to'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['message'], 'string', 'max' => 2000],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'send_to' => 'Send To',
            'name' => 'Name',
            'message' => 'Message',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function addFeedbackMessage($data)
    {
        if (empty($data)) {
            return;
        }
        $record = new self();
        $record->setAttributes($data);
        $record->save();
    }
}
