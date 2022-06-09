<?php

namespace app\controllers;

use app\models\TomProject;
use app\models\TomProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for TomProject model.
 */
class ProjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TomProject models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TomProjectSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);
        $tasks = $searchModel->searchTasks(1);
        $reports = $searchModel->searchOne(1);


        $reports_size = count($tasks);
        echo("<script>console.log('PHP: " .$reports_size . "');</script>");
        $complete_state = array();
        for ($i = 0;$i <= 2; $i++) {
            $complete_state[$i+1] = 0;
        }

        $completed = 0;
        foreach ($reports as $report) {
            $complete_state[$report['task_id']]+=$report['percent_done'];
            //echo("<script>console.log('PHP: " . $complete_state[$report['task_id']] . "');</script>");
        }


        foreach ($complete_state as $state) {
            if ($state==100) {
                $completed++;
            }
            echo("<script>console.log('PHP: " .$state . "');</script>");
        }

        $current_value= number_format(($completed/$reports_size)*100, 2);
        $status = "The project is not yet complete. Current progress is ".$current_value."%.";

        if ($completed/$reports_size == 1) {
            $status = "The project has been completed!";
        }


        return $this->render('index', [
            'completedReports' => $current_value,
            'status' => $status
        ]);
    }
}
