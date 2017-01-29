<?php

use yii\db\Migration;

class m170128_190023_create_match_datasheet extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%match_datasheet}}', [
            'id' => $this->primaryKey(),
            'player_id' => $this->integer()->notNull(),
            'match_id' => $this->integer()->notNull(),
            'goals' => $this->integer()->notNull()->defaultValue(0),
            'assists' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('fk_match_goals_player_id', '{{%match_datasheet}}', 'player_id', '{{%players}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_match_goals_match_id', '{{%match_datasheet}}', 'match_id', '{{%matches}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_match_goals_player_id', '{{%match_datasheet}}');
        $this->dropForeignKey('fk_match_goals_match_id', '{{%match_datasheet}}');
        $this->dropTable('{{%match_datasheet}}');
    }
}
