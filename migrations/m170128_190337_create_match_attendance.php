<?php

use yii\db\Migration;

class m170128_190337_create_match_attendance extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%match_attendance}}', [
            'id' => $this->primaryKey(),
            'match_id' => $this->integer()->notNull(),
            'player_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk_match_attendance_match_id', '{{%match_attendance}}', 'match_id', '{{%matches}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_match_attendance_player_id', '{{%match_attendance}}', 'player_id', '{{%players}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_match_attendance_player_id', '{{%match_attendance}}');
        $this->dropForeignKey('fk_match_attendance_match_id', '{{%match_attendance}}');
        $this->dropTable('{{%match_attendance}}');
    }
}
