<?php

use yii\db\Migration;

class m170121_184737_create_places extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%places}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'deleted' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_places_created_by', '{{%places}}', 'created_by', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_places_created_by', '{{%places}}');
        $this->dropTable('{{%places}}');
    }
}
