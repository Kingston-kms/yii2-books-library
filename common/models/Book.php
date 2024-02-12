<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $isbn
 * @property string|null $title
 * @property string|null $published_date
 * @property int|null $page_count
 * @property string|null $thumbnail_url
 * @property string|null $short_description
 * @property string|null $long_description
 * @property int $status
 *
 * @property BookAuthor[] $bookAuthors
 * @property BookCategory[] $bookCategories
 * @property Status $status0
 */
class Book extends \yii\db\ActiveRecord
{

    public static array $columnMapping = [
        'publishedDate' => 'published_date',
        'thumbnailUrl' => 'thumbnail_url',
        'shortDescription' => 'short_description',
        'longDescription' => 'long_description',
        'pageCount' => 'page_count'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['published_date'], 'safe'],
            [['page_count', 'status'], 'integer'],
            [['isbn', 'title'], 'string', 'max' => 255],
            [['thumbnail_url'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 2000],
            [['long_description'], 'string', 'max' => 5000],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'ISBN',
            'title' => 'Title',
            'published_date' => 'Published Date (UTC)',
            'page_count' => 'Page Count',
            'thumbnail_url' => 'Thumbnail Url',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'status' => 'Status',
        ];
    }


    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book' => 'id']);
    }

    /**
     * Gets query for [[BookCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookCategories()
    {
        return $this->hasMany(BookCategory::class, ['book' => 'id']);
    }

    /**
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Status::class, ['id' => 'status']);
    }
    public static function hasBookByIsbn(string $isbn)
    {
        return self::find()->where(['isbn' => $isbn])->exists();
    }

    public static function addBook(&$data): Book|bool
    {
        if (isset($data['isbn']) && self::hasBookByIsbn($data['isbn'])) return false;

        $book = new self();
        $book->setAttributes($data);
        $book->save();
        return $book;
    }
}
