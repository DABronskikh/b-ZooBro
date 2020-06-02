<?php

namespace app\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order as orderModel;

/**
 * order represents the model behind the search form of `app\models\order`.
 */
class order extends orderModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pet_id', 'price_id', 'status_id', 'user_id'], 'integer'],
            [['size', 'address', 'date_create', 'date_delivery', 'time_delivery', 'comment'], 'safe'],
            [['cost'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = orderModel::find();

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
            'id' => $this->id,
            'pet_id' => $this->pet_id,
            'price_id' => $this->price_id,
            'status_id' => $this->status_id,
            'date_create' => $this->date_create,
            'date_delivery' => $this->date_delivery,
            'time_delivery' => $this->time_delivery,
            'user_id' => $this->user_id,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
