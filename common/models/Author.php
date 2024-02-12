<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 *
 * @property BookAuthor[] $bookAuthors
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author' => 'id']);
    }

    public static function getAuthorListWithId()
    {
        $data = self::find()->select(['id' , 'name'])->asArray()->all();
        return ArrayHelper::map($data, 'id' , 'name');
    }

    public static function hasAuthor(string $name)
    {
        return self::find()->where(['name' => $name])->exists();
    }
    public static function addAuthor(string $name)
    {
        if (self::hasAuthor($name)) {
            return self::find()->select(['id'])->where(['name' => $name])->scalar();
        }
        $newAuthor = new self();
        $newAuthor->name = $name;
        $newAuthor->save();

        return $newAuthor->id;
    }
}
