<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Termcustomers;

/**
 * TermcustomersSearch represents the model behind the search form about `lukisongroup\master\models\Termcustomers`.
 */
class TermcustomersSearch extends Termcustomers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_TERM', 'STATUS'], 'integer'],
            [['NM_TERM', 'CUST_KD', 'CUST_NM', 'CUST_SIGN', 'PRINCIPAL_KD', 'PRINCIPAL_NM', 'PRINCIPAL_SIGN', 'DIST_KD', 'DIST_NM', 'DIST_SIGN', 'DCRP_SIGNARURE', 'PERIOD_START', 'PERIOD_END', 'TARGET_TEXT', 'RABATE_CNDT', 'TOP', 'CREATED_BY', 'CREATED_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
            [['TARGET_VALUE', 'GROWTH'], 'number'],
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
        $query = Termcustomers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID_TERM' => $this->ID_TERM,
            'PERIOD_START' => $this->PERIOD_START,
            'PERIOD_END' => $this->PERIOD_END,
            'TARGET_VALUE' => $this->TARGET_VALUE,
            'GROWTH' => $this->GROWTH,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'NM_TERM', $this->NM_TERM])
            ->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'CUST_SIGN', $this->CUST_SIGN])
            ->andFilterWhere(['like', 'PRINCIPAL_KD', $this->PRINCIPAL_KD])
            ->andFilterWhere(['like', 'PRINCIPAL_NM', $this->PRINCIPAL_NM])
            ->andFilterWhere(['like', 'PRINCIPAL_SIGN', $this->PRINCIPAL_SIGN])
            ->andFilterWhere(['like', 'DIST_KD', $this->DIST_KD])
            ->andFilterWhere(['like', 'DIST_NM', $this->DIST_NM])
            ->andFilterWhere(['like', 'DIST_SIGN', $this->DIST_SIGN])
            ->andFilterWhere(['like', 'DCRP_SIGNARURE', $this->DCRP_SIGNARURE])
            ->andFilterWhere(['like', 'TARGET_TEXT', $this->TARGET_TEXT])
            ->andFilterWhere(['like', 'RABATE_CNDT', $this->RABATE_CNDT])
            ->andFilterWhere(['like', 'TOP', $this->TOP])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}