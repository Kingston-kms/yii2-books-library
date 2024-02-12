<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property int $key
 * @property string|null $value
 */
class Setting extends \yii\db\ActiveRecord
{
    const EMAIL_KEY = 'email';
    const BOOK_PAGE_COUNT_KEY = 'book_page_count';
    const SOURCE_URL_KEY = 'source_url';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public static function getSettingByKey(string $key): string|null
    {
        if (self::hasSetting($key)) {
            return self::find()->select(['value'])->where(['key' => $key])->scalar();
        }
        return null;
    }

    private static function hasSetting(string $key): bool
    {
        return self::find()->where(['key' => $key])->exists();
    }
    public static function addSetting(string $key, string $value): bool
    {
        $db = self::getDb();
        try {
            return $db->createCommand()->insert(self::tableName(), ['key' => $key, 'value' => $value])->execute();
        } catch (Exception $e) {
            Yii::error("New record not inserted");
            Yii::error($e->getTraceAsString());
        }
        return false;
    }
}
