<?php

use yii\db\Migration;

/**
 * Class m180119_121314_extend_profile_table.php
 */
class m180119_121314_extend_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('profile', 'second_name', $this->string());
        $this->addColumn('profile', 'language', $this->string());
        $this->addColumn('profile', 'public_fields', $this->string());
        $this->addColumn('profile', 'city', $this->string());
        $this->addColumn('profile', 'country', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('profile', 'second_name');
        $this->dropColumn('profile', 'language');
        $this->dropColumn('profile', 'public_fields');
        $this->dropColumn('profile', 'city');
        $this->dropColumn('profile', 'country');
    }

}
