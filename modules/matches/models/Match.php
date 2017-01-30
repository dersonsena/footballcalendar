<?php

namespace app\modules\matches\models;

use app\components\ModelBase;
use app\models\Flag;
use app\models\Setting;
use app\modules\entries\models\Competition;
use app\modules\entries\models\Place;
use app\modules\entries\models\Player;
use app\modules\entries\models\Team;
use Exception;
use OutOfBoundsException;
use Yii;

/**
 * This is the model class for table "{{%matches}}".
 *
 * @property integer $id
 * @property integer $place_id
 * @property integer $team_id
 * @property integer $status_id
 * @property integer $type_id
 * @property integer $decision_id
 * @property integer $competition_id
 * @property string $description
 * @property string $date
 * @property integer $score_owner
 * @property integer $score_guest
 * @property string $observations
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 *
 * @property MatchDatasheet[] $dataSheet
 * @property Competition $competition
 * @property Flag $decision
 * @property Place $place
 * @property Flag $status
 * @property Team $team
 * @property Flag $type
 */
class Match extends ModelBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%matches}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'team_id', 'status_id', 'type_id', 'date'], 'required'],
            [['place_id', 'team_id', 'status_id', 'type_id', 'decision_id', 'competition_id', 'score_owner', 'score_guest', 'created_by'], 'integer'],
            ['description', 'string', 'max' => 60],
            ['date', 'date', 'format' => 'php:d/m/Y'],
            [['date', 'created_at', 'updated_at', 'observations'], 'safe'],
            [['competition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competition::className(), 'targetAttribute' => ['competition_id' => 'id']],
            [['decision_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['decision_id' => 'id']],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['place_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'place_id' => 'Local do Jogo',
            'team_id' => 'Adversário',
            'status_id' => 'Status',
            'type_id' => 'Tipo de Jogo',
            'decision_id' => 'Decisão',
            'competition_id' => 'Competição',
            'description' => 'Descrição',
            'date' => 'Data',
            'score_owner' => 'Score Owner',
            'score_guest' => 'Score Guest',
            'observations' => 'Observações do Jogo',
            'created_at' => $this->createdAtLabel,
            'updated_at' => $this->updateAtLabel,
            'created_by' => $this->createdByLabel,
        ];
    }

    public function afterFind()
    {
        //$this->observations = Yii::$app->formatter->asNtext($this->observations);
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        $teamName = Setting::getSettingByAbbreviation('TEAM_NAME')->value;
        $this->description = "{$teamName} {$this->score_owner} X {$this->score_guest} {$this->team->name}";

        if ($this->isFinalized())
            $this->decision_id = $this->getDecisionFlag();

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataSheet()
    {
        return $this->hasMany(MatchDatasheet::className(), ['match_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetition()
    {
        return $this->hasOne(Competition::className(), ['id' => 'competition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecision()
    {
        return $this->hasOne(Flag::className(), ['id' => 'decision_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Flag::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Flag::className(), ['id' => 'type_id']);
    }

    public function isSchedule()
    {
        return $this->status_id === Flag::MATCH_STATUS_SCHEDULED;
    }

    public function isFinalized()
    {
        return $this->status_id === Flag::MATCH_STATUS_FINALIZED;
    }

    public function isFriendly()
    {
        return $this->status_id === Flag::MATCH_TYPE_FRIENDLY;
    }

    public function isCompetition()
    {
        return $this->status_id === Flag::MATCH_TYPE_COMPETITION;
    }

    public function isVictory()
    {
        return $this->decision_id === Flag::MATCH_DECISION_VICTORY;
    }

    public function isDefeat()
    {
        return $this->decision_id === Flag::MATCH_DECISION_DEFEAT;
    }

    public function isDraw()
    {
        return $this->decision_id === Flag::MATCH_DECISION_DRAW;
    }

    /**
     * @param MatchDatasheet[] $dataSheet
     * @throws Exception
     */
    public function registerDataSheet(array $dataSheet)
    {
        MatchDatasheet::deleteAll(['match_id' => $this->id]);

        if (empty($dataSheet))
            return;

        foreach ($dataSheet as $row) {
            $newDataSheet = new MatchDatasheet;
            $newDataSheet->match_id = $this->id;
            $newDataSheet->player_id = $row->player_id;
            $newDataSheet->goals = $row->goals;
            $newDataSheet->assists = $row->assists;

            if (!$newDataSheet->save())
                throw new Exception('Erro ao salvar a registro da ficha técnica.');
        }
    }

    /**
     * @return int
     */
    public function getDecisionFlag()
    {
        if ($this->score_owner > $this->score_guest) {
            return Flag::MATCH_DECISION_VICTORY;
        } else if ($this->score_owner == $this->score_guest) {
            return Flag::MATCH_DECISION_DRAW;
        } else {
            return Flag::MATCH_DECISION_DEFEAT;
        }
    }

    public static function getStatusList($statusId = null)
    {
        $list = [
            Flag::MATCH_STATUS_SCHEDULED => 'Agendado',
            Flag::MATCH_STATUS_FINALIZED => 'Finalizado',
        ];

        if (is_null($statusId))
            return $list;

        if (!array_key_exists($statusId, $list)) {
            throw new OutOfBoundsException('Não existe status com ID ' . $statusId);
        }

        return $list[$statusId];
    }

    public function getStatusLabel()
    {
        $selectedStatus = self::getStatusList($this->status_id);
        $params = [];

        switch ($this->status_id) {
            case Flag::MATCH_STATUS_SCHEDULED :
                $params = ['cssClass' => 'label-warning', 'iconClass' => 'fa fa-calendar'];
                break;
            case Flag::MATCH_STATUS_FINALIZED :
                $params = ['cssClass' => 'label-success', 'iconClass' => 'fa fa-check-circle'];
                break;
        }

        return '<span class="label ' . $params['cssClass'] . '">
            <i class="' . $params['iconClass'] . '"></i> ' . $selectedStatus .
            '</span>';
    }

    public static function getDecisionList($decisionId = null)
    {
        $list = [
            Flag::MATCH_DECISION_VICTORY => 'Vitória',
            Flag::MATCH_DECISION_DRAW => 'Empate',
            Flag::MATCH_DECISION_DEFEAT => 'Derrota',
        ];

        if (is_null($decisionId))
            return $list;

        if (!array_key_exists($decisionId, $list)) {
            throw new OutOfBoundsException('Não existe a decisão com ID ' . $decisionId);
        }

        return $list[$decisionId];
    }

    public function getDecisionLabel($shortLabel = false)
    {
        $selectedStatus = self::getDecisionList($this->decision_id);
        $params = [];

        switch ($this->decision_id) {
            case Flag::MATCH_DECISION_DRAW :
                $params = ['cssClass' => 'label-warning', 'iconClass' => 'fa fa-calendar'];
                $selectedStatus = (!$shortLabel ? $selectedStatus : 'E');
                break;
            case Flag::MATCH_DECISION_DEFEAT :
                $params = ['cssClass' => 'label-danger', 'iconClass' => 'fa fa-minus-circle'];
                $selectedStatus = (!$shortLabel ? $selectedStatus : 'D');
                break;
            case Flag::MATCH_DECISION_VICTORY :
                $params = ['cssClass' => 'label-success', 'iconClass' => 'fa fa-check-circle'];
                $selectedStatus = (!$shortLabel ? $selectedStatus : 'V');
                break;
        }

        return '<span class="label ' . $params['cssClass'] . '">
            <i class="' . $params['iconClass'] . '"></i> ' . $selectedStatus .
            '</span>';
    }

    public static function getTypeList($typeId = null)
    {
        $list = [
            Flag::MATCH_TYPE_FRIENDLY => 'Amistoso',
            Flag::MATCH_TYPE_COMPETITION => 'Competição',
        ];

        if (is_null($typeId))
            return $list;

        if (!array_key_exists($typeId, $list)) {
            throw new OutOfBoundsException('Não existe o tipo com ID ' . $typeId);
        }

        return $list[$typeId];
    }

    public static function getArtillery()
    {
        $sql = "
            SELECT p.id, p.name, (
                SELECT SUM(goals)
                FROM ". MatchDatasheet::tableName() ." AS md
                WHERE md.player_id = p.id
                GROUP BY md.player_id
            ) AS goals
            FROM ". Player::tableName() ." AS p
            WHERE p.status = 1
            ORDER BY goals DESC, p.name ASC
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public static function getGoalsBalance()
    {
        $sql = "
            SELECT 
                AVG(m.score_owner) AS avg_owner, AVG(m.score_guest) AS avg_guest,
                SUM(m.score_owner) AS sum_owner, SUM(m.score_guest) AS sum_guest,
                (SUM(m.score_owner) - SUM(m.score_guest)) AS balance
            FROM ". Match::tableName() ." AS m
        ";

        return Yii::$app->db->createCommand($sql)->queryOne();
    }

    public static function getLastMatches(int $limit = 10)
    {
        return static::find()
            ->select(['id', 'description', 'date', 'decision_id'])
            ->where(['status_id' => Flag::MATCH_STATUS_FINALIZED])
            ->orderBy('date DESC, created_at DESC')
            ->limit($limit)
            ->all();
    }
}
