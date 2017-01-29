<?php

namespace app\modules\matches\models;

use app\components\ModelBase;
use app\modules\entries\models\Player;

/**
 * This is the model class for table "{{%match_datasheet}}".
 *
 * @property integer $id
 * @property integer $player_id
 * @property integer $match_id
 * @property integer $goals
 * @property integer $assists
 *
 * @property Match $match
 * @property Player $player
 */
class MatchDatasheet extends ModelBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%match_datasheet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player_id', 'match_id', 'goals', 'assists'], 'required'],
            [['player_id', 'match_id', 'goals', 'assists'], 'integer'],
            [['match_id'], 'exist', 'skipOnError' => true, 'targetClass' => Match::className(), 'targetAttribute' => ['match_id' => 'id']],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Player::className(), 'targetAttribute' => ['player_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'player_id' => 'Player ID',
            'match_id' => 'Match ID',
            'goals' => 'Gols',
            'assists' => 'Assists',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatch()
    {
        return $this->hasOne(Match::className(), ['id' => 'match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::className(), ['id' => 'player_id']);
    }
}
