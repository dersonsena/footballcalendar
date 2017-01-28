<?php

use yii\db\Migration;

class m170128_181417_create_competitions extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%competitions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'responsible' => $this->string(60)->notNull(),
            'responsible_phone' => $this->string(11)->notNull(),
            'responsible_whatsapp' => $this->string(11),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'deleted' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_competitions_created_by', '{{%competitions}}', 'created_by', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_competitions_created_by', '{{%competitions}}');
        $this->dropTable('{{%competitions}}');
    }
}
