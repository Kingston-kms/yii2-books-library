<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_category
 *
 * @property BookCategory[] $bookCategories
 * @property Category $parentCategory
 */
class Category extends \yii\db\ActiveRecord
{
    const DEFAULT_CATEGORY_NAME = "Новинки";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
            ['parent_category', 'number']
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
            'parent_category' => 'Parent Category'
        ];
    }

    /**
     * Gets query for [[BookCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookCategories()
    {
        return $this->hasMany(BookCategory::class, ['category' => 'id']);
    }
    public function getParentCategory()
    {
        return $this->hasOne(self::class, ['id' => 'parent_category']);
    }
    public static function addCategory(string $categoryName)
    {
        if (self::hasCategory($categoryName)) {
            return self::find()->select(['id'])->where(['name' => $categoryName])->scalar();
        }
        $category = new self();
        $category->name = $categoryName;
        $category->save();
        return $category->id;
    }
    public static function hasCategory(string $name): bool
    {
        return self::find()->where(['name' => $name])->exists();
    }

    public static function getCategoryListWithId(): array
    {
        $data = self::find()->select(['id' , 'name'])->asArray()->all();
        return ArrayHelper::map($data, 'id' , 'name');
    }
}
