<?php

use yii\db\Migration;

class m160716_192218_create_users extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'name' => $this->string(60)->notNull(),
            'email' => $this->string(60)->notNull(),
            'password' => $this->string(60)->notNull(),
            'token' => $this->string(100)->defaultValue(null),
            'auth_key' => $this->string(100)->defaultValue(null),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'deleted' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()
        ], $tableOptions);

        $now = new DateTime;

        $this->insert("{{%users}}", [
            'group_id' => 1,
            'name' => 'Administrador',
            'email' => '
            ',
            'password' => Yii::$app->security->generatePasswordHash($_ENV['ADMIN_PASSWORD']),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s')
        ]);

        $this->addForeignKey('fk_users_created_by', '{{%users}}', 'created_by', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_users_group_id', '{{%users}}', 'group_id', '{{%groups}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_users_created_by', '{{%users}}');
        $this->dropForeignKey('fk_users_group_id', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
