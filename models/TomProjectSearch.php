<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TomProject;
use yii\db\Exception;

/**
 * TomProjectSearch represents the model behind the search form of `app\models\TomProject`.
 */
class TomProjectSearch extends TomProject
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
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
        $query = TomProject::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    /**
     */
    public function searchOne($id) {
        $connection = Yii::$app->getDB();
        $command = $connection ->createCommand("
        SELECT tom_report.id,tom_report.task_id,tom_report.percent_done FROM
        (
            SELECT tom_task.id as TaskID 
            FROM tom_task, 
                (
                    SELECT id as projectID FROM tom_project
                    WHERE id = ".$id."
                ) as P
            WHERE P.projectID = tom_task.project_id
        ) as T
        INNER JOIN tom_report ON tom_report.task_id=T.taskID
        ");

        $result = $command->queryAll();

        return $result;

    }

    public function searchTasks($id) {
        $connection = Yii::$app->getDB();
        $command = $connection ->createCommand("
            SELECT tom_task.id as TaskID 
            FROM tom_task, 
                (
                    SELECT id as projectID FROM tom_project
                    WHERE id = ".$id."
                ) as P
            WHERE P.projectID = tom_task.project_id
        ");

        $result = $command->queryAll();

        return $result;

    }
}
