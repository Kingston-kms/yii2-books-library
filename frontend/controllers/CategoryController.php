<?php

namespace frontend\controllers;

use common\models\Book;
use common\models\BookCategory;
use common\models\Category;
use common\models\Setting;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->where(['parent_category' => $id])
        ]);
        $childCategories = ArrayHelper::getColumn($dataProvider->getModels(),'id');
        $defaultBookPageCount = Setting::getSettingByKey(Setting::BOOK_PAGE_COUNT_KEY);
        $bookDataProvider = new ActiveDataProvider([
            'query' => Book::find()->alias('b')->leftJoin(['bc' => BookCategory::tableName()], 'bc.book = b.id')
            ->where(['bc.category' => [$id] + $childCategories]),
            'pagination' => [
                'pageSize' => $defaultBookPageCount
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'bookDataProvider' => $bookDataProvider
        ]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
