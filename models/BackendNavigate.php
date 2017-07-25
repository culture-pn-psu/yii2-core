<?php

namespace culturePnPsu\core\models;

use Yii;
use yii\helpers\Html;

/**
 * Description of navigate
 *
 * @author madone
 */
class BackendNavigate extends \culturePnPsu\menu\models\Navigate {
    
    public function getCount($router) {
        $count = '';
        switch ($router) {
            /**
             * material
             */
            case '/material':
                if (Yii::$app->user->can('staffMaterial')) {
                    $count = \backend\modules\material\models\Repair::find()
                            ->where(['IN', 'status', ['1']])
                            //->orWhere(['IS', 'status', NULL])
                            ->count();
                }

                if (Yii::$app->user->can('staffIt')) {
                    $count = \backend\modules\material\models\Repair::find()
                                    ->where(['type' => 2, 'status' => 2, 'staff_status' => null])->count();
                }

                $count = $count ? ' <small class="label bg-yellow">' . $count . '</small>' : '';
                break;

            /**
             * repair
             */
            case '/repair':
            //case '/repair/request':
                
                 if (Yii::$app->user->can('staffMaterial')) {
                    $searchModel = new \culturePnPsu\repair\models\RepairStaffSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    $count = $dataProvider->getTotalCount();
                    //$count = $count ? '<small class="label pull-right bg-yellow">' . $count . '</small>' : '';
                }
                 if (Yii::$app->user->can('staffIt')) {
                    $searchModel = new \culturePnPsu\repair\models\ComConsiderSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    $count = $dataProvider->getTotalCount();
                    //$count = $count ? '<small class="label pull-right bg-yellow">' . $count . '</small>' : '';
                }
                $count = $count ? '<small class="label pull-right bg-yellow">' . $count . '</small>' : '';
                break;


            case '/repair/default/index':
                $count = \backend\modules\repair\models\Repair::find()
                        ->where([
                            'created_by' => Yii::$app->user->id,
                        ])
                        ->count();
                //$count = $count ? '<small class="label ">' . $count . '</small>' : '';
                $count = $count ? Html::tag('b', ' (' . $count . ')') : '';
                break;

            case '/repair/default/draft':
                $count = \backend\modules\repair\models\Repair::find()
                        ->where([
                            'created_by' => Yii::$app->user->id,
                            'status' => 0
                        ])
                        ->count();
                $count = $count ? Html::tag('b', ' (' . $count . ')', ['class' => 'text-red']) : '';
                break;

            case '/repair/default/done':
                $count = \backend\modules\repair\models\Repair::find()
                        ->where([
                            'created_by' => Yii::$app->user->id,
                            'status' => [6]
                        ])
                        ->count();
                $count = $count ? '<small class="label pull-right label-success">' . $count . '</small>' : '';
                break;

            ####################################
            case '/repair':
            case '/repair/staff':
                if (Yii::$app->user->can('staffMaterial')) {
                    $count = \backend\modules\repair\models\Repair::find()
                            ->where(['NOT IN', 'status', [0]])
                            ->count();
                    $count = $count ? '<small class="label pull-right bg-yellow">' . $count . '</small>' : '';
                }
                break;

            ####################

            case '/repair/repairing':
                $count = \backend\modules\repair\models\Repair::find()
                        ->where([
                            'status' => 5
                        ])
                        ->count();
                $count = $count ? '<small class="label pull-right bg-blue">' . $count . '</small>' : '';
                break;

            case '/repair/com':
                $count = \backend\modules\repair\models\Repair::find()
                        ->where(['type' => 2, 'status' => 2, 'staff_status' => null])
                        ->count();
                $count = $count ? '<small class="label pull-right ' . (Yii::$app->user->can('staffMaterial') ? 'bg-blue' : 'bg-yellow') . '">' . $count . '</small>' : '';
                break;

            case '/repair/approve':
                $count = \backend\modules\repair\models\Repair::find()
                        ->andWhere(['status' => [2]])
                        //->andWhere(['not', ['staff_status' => null]])
                        //->andWhere(['not', ['boss_status' => null]])
                        //->where(['not', ['staff_status' => null], 'not', ['boss_status' => null]])
                        ->count();
                //echo $count;
                $count = $count ? '<small class="label pull-right ' . (Yii::$app->user->can('staffMaterial') ? 'bg-blue' : 'bg-yellow') . '">' . $count . '</small>' : '';
                break;

            case '/repair/done':
                $count = \backend\modules\repair\models\Repair::find()
                        ->where(['status' => 6])
                        ->count();
                $count = $count ? '<small class="label pull-right label-success">' . $count . '</small>' : '';
                break;

            /**
             * reserve-car
             */
            case '/reserve-car/default/index':
                $searchModel = new \backend\modules\reserveCar\models\ReserveCarSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span> (' . $count . ')</span>' : '';
                break;

            case '/reserve-car/default/draft':
                $searchModel = new \backend\modules\reserveCar\models\ReserveCarDraftSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span class="text-red"> (' . $count . ')</span>' : '';
                break;

            case '/reserve-car/default/offer':
                $searchModel = new \backend\modules\reserveCar\models\ReserveCarOfferSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span> (' . $count . ')</span>' : '';
                break;

            case '/reserve-car/default/result':
                $searchModel = new \backend\modules\reserveCar\models\ReserveCarResultSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span> (' . $count . ')</span>' : '';
                break;

            case '/reserve-car/staff/index':
                $searchModel = new \backend\modules\reserveCar\models\ReserveCarStaffSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<small class="label pull-right label-info">' . $count . '</small>' : '';
                break;

            case '/reserve-car/staff/consider':
                $searchModel = new \backend\modules\reserveCar\models\ReserveStaffConsiderSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span> (' . $count . ')</span>' : '';
                break;

            case '/reserve-car/staff/comeback':
                $searchModel = new \backend\modules\reserveCar\models\ReserveStaffComebackSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span> (' . $count . ')</span>' : '';
                break;

            case '/reserve-car/staff/result':
                $searchModel = new \backend\modules\reserveCar\models\ReserveStaffResultSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getTotalCount();
                $count = $count ? '<span> (' . $count . ')</span>' : '';
                break;
        }
        $this->count = $count;
        //return $count;
    }

}
