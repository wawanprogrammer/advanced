<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\DraftGeoSub;

/**
 * DraftGeoSubSearch represents the model behind the search form about `lukisongroup\master\models\DraftGeoSub`.
 */
class DraftGeoSubSearch extends DraftGeoSub
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'GEO_SUB', 'GEO_ID', 'CUST_MAX_NORMAL', 'CUST_MAX_LAYER', 'STATUS'], 'integer'],
            [['GEO_DCRIP', 'START_LAT', 'START_LONG', 'CITY_ID', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DraftGeoSub::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'GEO_SUB' => $this->GEO_SUB,
            'GEO_ID' => $this->GEO_ID,
            'CUST_MAX_NORMAL' => $this->CUST_MAX_NORMAL,
            'CUST_MAX_LAYER' => $this->CUST_MAX_LAYER,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'GEO_DCRIP', $this->GEO_DCRIP])
            ->andFilterWhere(['like', 'START_LAT', $this->START_LAT])
            ->andFilterWhere(['like', 'START_LONG', $this->START_LONG])
            ->andFilterWhere(['like', 'CITY_ID', $this->CITY_ID])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
