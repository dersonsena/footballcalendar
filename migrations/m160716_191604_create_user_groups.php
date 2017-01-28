<?php

use yii\db\Migration;

class m160716_191604_create_user_groups extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%groups}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'system_group' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'can_delete' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'deleted' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()
        ], $tableOptions);

        $now = new DateTime;

        $this->insert("{{%groups}}", [
            'name' => 'Administradores',
            'system_group' => 1,
            'can_delete' => 0,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s')
        ]);

        $this->insert("{{%groups}}", [
            'name' => 'Atletas',
            'system_group' => 1,
            'can_delete' => 0,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s')
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%groups}}');
    }
}
