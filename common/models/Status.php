<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $name
 *
 * @property Book[] $books
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['status' => 'id']);
    }
    public static function getStatusListWithId(): array
    {
        $data = self::find()->select(['id' , 'name'])->asArray()->all();
        return ArrayHelper::map($data, 'id' , 'name');
    }
    public static function hasStatus(string $statusName): bool
    {
        return self::find()->where(['name' => $statusName])->exists();
    }
    public static function addStatus(string $statusName): bool|int|string|null
    {
        if (self::hasStatus($statusName)) {
            return self::find()->select(['id'])->where(['name' => $statusName])->scalar();
        }
        $status = new self();
        $status->name = $statusName;
        $status->save();
        return $status->id;
    }
}
