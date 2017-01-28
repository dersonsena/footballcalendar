<?php

use yii\db\Migration;

class m160716_231144_create_settings extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'abbreviation' => $this->string(20)->notNull(),
            'title' => $this->string(60)->notNull(),
            'description' => $this->string(150)->notNull(),
            'value' => $this->string(150)->notNull(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_settings_updated_by', '{{%settings}}', 'updated_by', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_settings_updated_by', '{{%settings}}');
        $this->dropTable('{{%settings}}');
    }
}
