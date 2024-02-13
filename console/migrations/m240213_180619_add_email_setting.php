<?php

use common\models\Setting;
use yii\db\Migration;

/**
 * Class m240213_180619_add_email_setting
 */
class m240213_180619_add_email_setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Setting::addSetting(Setting::EMAIL_KEY, 'admin@example.com');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Setting::deleteAll(['key' => Setting::EMAIL_KEY]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240213_180619_add_email_setting cannot be reverted.\n";

        return false;
    }
    */
}
