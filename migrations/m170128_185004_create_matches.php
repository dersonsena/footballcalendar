<?php

use yii\db\Migration;

class m170128_185004_create_matches extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%matches}}', [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'decision_id' => $this->integer(),
            'competition_id' => $this->integer(),
            'description' => $this->string(60),
            'date' => $this->date()->notNull(),
            'score_owner' => $this->integer(),
            'score_guest' => $this->integer(),
            'observations' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_matches_place_id', '{{%matches}}', 'place_id', '{{%places}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_matches_team_id', '{{%matches}}', 'team_id', '{{%teams}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_matches_status_id', '{{%matches}}', 'status_id', '{{%flags}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_matches_type_id', '{{%matches}}', 'type_id', '{{%flags}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_matches_decision_id', '{{%matches}}', 'decision_id', '{{%flags}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_matches_competition_id', '{{%matches}}', 'competition_id', '{{%competitions}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_matches_place_id', '{{%matches}}');
        $this->dropForeignKey('fk_matches_team_id', '{{%matches}}');
        $this->dropForeignKey('fk_matches_status_id', '{{%matches}}');
        $this->dropForeignKey('fk_matches_type_id', '{{%matches}}');
        $this->dropForeignKey('fk_matches_decision_id', '{{%matches}}');
        $this->dropForeignKey('fk_matches_competition_id', '{{%matches}}');
        $this->dropTable('{{%matches}}');
    }
}
