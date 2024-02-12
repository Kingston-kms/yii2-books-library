<?php

use common\models\Category;
use common\models\Setting;
use yii\db\Migration;

/**
 * Class m240212_120454_add_data
 */
class m240212_120454_add_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Setting::addSetting(Setting::BOOK_PAGE_COUNT_KEY, 20);
        Setting::addSetting(Setting::SOURCE_URL_KEY, 'https://gitlab.grokhotov.ru/hr/yii-test-vacancy/-/raw/master/books.json');
        Category::addCategory(Category::DEFAULT_CATEGORY_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Setting::deleteAll(['key' => Setting::BOOK_PAGE_COUNT_KEY]);
        Setting::deleteAll(['key' => Setting::SOURCE_URL_KEY]);
        Category::deleteAll(['name' => Category::DEFAULT_CATEGORY_NAME]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240212_120454_add_data cannot be reverted.\n";

        return false;
    }
    */
}
