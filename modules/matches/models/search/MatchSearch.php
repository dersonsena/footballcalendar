<?php

namespace app\modules\matches\models\search;

use app\modules\matches\models\Match;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class MatchSearch extends Match
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'decision_id', 'type_id'], 'integer'],
            ['date', 'date', 'format' => 'php:d/m/Y'],
            [['description'], 'string', 'max' => 60],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /** @var Query $query */
        $query = Match::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pagination']['pageSize'],
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                    'description' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate())
            return $dataProvider;

        $query->andFilterWhere([
            'status_id' => $this->status_id,
            'decision_id' => $this->decision_id,
            'type_id' => $this->type_id
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'date', Yii::$app->formatter->asDateUS($this->date)]);

        return $dataProvider;
    }
}