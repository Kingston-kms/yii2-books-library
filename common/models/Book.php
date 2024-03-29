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
    public $imageFile;
    public $_categories;
    public $_authors;
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
    public function afterFind()
    {
        parent::afterFind();
        $this->imageFile = \Yii::$app->params['frontendDomain'] . '/' . \Yii::$app->params['imageWebDir'] . '/' . $this->thumbnail_url;

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['published_date', 'imageFile', '_categories', '_authors'], 'safe'],
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
            'thumbnail_url' => 'Thumbnail Image',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'status' => 'Status',
            'imageFile' => 'Thumbnail Image',
            '_categories' => 'Category',
            '_authors' => 'Authors'
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!empty($this->_categories)) {
            foreach ($this->_categories as $category) {
                BookCategory::addBookCategory($this->id, $category);
            }
        }
        if (!empty($this->_authors)) {
            foreach ($this->_authors as $author) {
                BookAuthor::addBookAuthor($this->id, $author);
            }
        }

        if (!$insert) {
            if (!empty($this->_categories)) {
                BookCategory::deleteAll([
                    'AND',
                    ['book' => $this->id],
                    ['NOT IN', 'category', array_values($this->_categories)]
                ]);
            }
            if (!empty($this->_authors)) {
                BookAuthor::deleteAll([
                    'AND',
                    ['book' => $this->id],
                    ['NOT IN', 'author', array_values($this->_authors)]
                ]);
            }
        }
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
