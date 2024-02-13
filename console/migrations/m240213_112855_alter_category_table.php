<?php

use yii\db\Migration;

/**
 * Class m240213_112855_alter_category_table
 */
class m240213_112855_alter_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Category::tableName(), "parent_category", $this->integer(10)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Category::tableName(), 'parent_category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240213_112855_alter_category_table cannot be reverted.\n";

        return false;
    }
    */
}
