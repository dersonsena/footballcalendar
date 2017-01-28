<?php

namespace app\modules\entries\models\search;

use app\modules\entries\models\Competition;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class CompetitionSearch extends Competition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'responsible'], 'string', 'max' => 60],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (empty($params['status']))
            $this->status = '';
        
        /** @var Query $query */
        $query = Competition::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pagination']['pageSize'],
            ],
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate())
            return $dataProvider;

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'responsible', $this->responsible]);

        return $dataProvider;
    }
}