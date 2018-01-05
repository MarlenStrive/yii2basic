<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `status`.
 */
class m180105_162032_create_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('status', [
            //'id' => $this->primaryKey(),
            'id' => Schema::TYPE_PK,
            'message' => Schema::TYPE_TEXT . ' NOT NULL DEFAULT \'\'',
            'permissions' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('status');
    }
}
