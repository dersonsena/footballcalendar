<?php

use yii\db\Migration;

class m170128_190520_insert_matches_flags extends Migration
{
    public function safeUp()
    {
        $this->batchInsert("{{%flags}}", ['namespace', 'description'], [
            ['MATCH_STATUS', 'Agendado'],
            ['MATCH_STATUS', 'Finalizado'],
            ['MATCH_TYPE', 'Amistoso'],
            ['MATCH_TYPE', 'Competição'],
        ]);
    }

    public function safeDown()
    {
    }
}
