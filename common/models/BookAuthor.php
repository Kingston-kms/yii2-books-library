<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "book_author".
 *
 * @property int $id
 * @property int $book
 * @property int $author
 *
 * @property Author $author0
 * @property Book $book0
 */
class BookAuthor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book', 'author'], 'required'],
            [['book', 'author'], 'integer'],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author' => 'id']],
            [['book'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book' => 'Book',
            'author' => 'Author',
        ];
    }

    /**
     * Gets query for [[Author0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(Author::class, ['id' => 'author']);
    }

    /**
     * Gets query for [[Book0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook0()
    {
        return $this->hasOne(Book::class, ['id' => 'book']);
    }

    public static function hasBookAuthor(int $bookId, int $authorId) {
        return self::find()->where(['book' => $bookId, 'author' => $authorId])->exists();
    }

    public static function addBookAuthor(int $bookId, int $authorId) {
        if (self::hasBookAuthor($bookId, $authorId)) {
            return;
        }
        $db = self::getDb();
        try {
            $db->createCommand()->insert(self::tableName(), ['book' => $bookId, 'author' => $authorId])->execute();
        } catch (Exception $e) {
            Yii::error("New BookAuthor record not inserted");
            Yii::error($e->getTraceAsString());
        }
    }
}
