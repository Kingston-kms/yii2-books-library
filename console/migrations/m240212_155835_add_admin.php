<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m240212_155835_add_admin
 */
class m240212_155835_add_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::deleteAll(['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240212_155835_add_admin cannot be reverted.\n";

        return false;
    }
    */
}
