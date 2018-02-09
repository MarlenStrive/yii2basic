<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180110_162042_extend_status_table_for_slugs
 */
class m180110_162042_extend_status_table_for_slugs extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->execute('TRUNCATE TABLE status');
        $this->addColumn('{{%status}}', 'slug', Schema::TYPE_STRING . ' NOT NULL');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%status}}', 'slug');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180110_162042_extend_status_table_for_slugs cannot be reverted.\n";

        return false;
    }
    */
}
