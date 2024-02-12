<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "book_category".
 *
 * @property int $id
 * @property int $book
 * @property int $category
 *
 * @property Book $book0
 * @property Category $category0
 */
class BookCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book', 'category'], 'required'],
            [['book', 'category'], 'integer'],
            [['book'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category' => 'id']],
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
            'category' => 'Category',
        ];
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

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }

    public static function hasBookCategory(int $bookId,int $categoryId): bool
    {
        return self::find()->where(['book' => $bookId, 'category' => $categoryId])->exists();
    }

    public static function addBookCategory(int $bookId, int $categoryId)
    {
        if (self::hasBookCategory($bookId, $categoryId)) {
            return;
        }
        $db = self::getDb();
        try {
            $db->createCommand()->insert(self::tableName(), ['book' => $bookId, 'category' => $categoryId])->execute();
        } catch (Exception $e) {
            Yii::error("New BookCategory record not inserted");
            Yii::error($e->getMessage());
            Yii::error($e->getTraceAsString());
        }
    }
}
