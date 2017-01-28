<?php

use yii\db\Migration;

class m170121_184830_create_teams extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%teams}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'deleted' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_teams_created_by', '{{%teams}}', 'created_by', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_teams_created_by', '{{%teams}}');
        $this->dropTable('{{%teams}}');
    }
}
