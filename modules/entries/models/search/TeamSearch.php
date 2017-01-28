<?php

namespace app\modules\entries\models\search;

use app\modules\entries\models\Team;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class TeamSearch extends Team
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 60],
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
        $query = Team::find();

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

        return $dataProvider;
    }
}