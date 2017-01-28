<?php

use yii\db\Migration;

class m160716_232556_create_flags extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%flags}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(60)->notNull(),
            'namespace' => $this->string(20)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1)
        ], $tableOptions);

        $this->batchInsert("{{%flags}}", ['namespace', 'description'], [
            ['GENDER', 'Masculino'],
            ['GENDER', 'Feminino'],
            ['SETTING_TYPE', 'Text'],
            ['SETTING_TYPE', 'Integer'],
            ['SETTING_TYPE', 'Decimal'],
            ['SETTING_TYPE', 'Boolean'],
            ['MATCH_DECISION', 'Vitória'],
            ['MATCH_DECISION', 'Derrota'],
            ['MATCH_DECISION', 'Empate'],
        ]);

        $this->addForeignKey('fk_settings_type_id', '{{%settings}}', 'type_id', '{{%flags}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_settings_type_id', '{{%settings}}');

        $this->dropTable('{{%flags}}');
    }
}
