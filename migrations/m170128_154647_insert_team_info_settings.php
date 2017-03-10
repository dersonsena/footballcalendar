<?php

use app\models\Flag;
use yii\db\Migration;

class m170128_154647_insert_team_info_settings extends Migration
{
    public function safeUp()
    {
        $this->batchInsert("{{%settings}}", ['type_id', 'abbreviation', 'title', 'description', 'value'], [
            [Flag::SETTING_TYPE_TEXT, 'TEAM_NAME', 'Nome do Time', 'Informe o nome desta equipe', 'América FC'],
            [Flag::SETTING_TYPE_TEXT, 'TEAM_AVATAR', 'Escudo do Time', 'Selecione uma imagem que representa o escudo do time.', 'no-avatar.png'],
        ]);
    }

    public function safeDown()
    {
    }
}
