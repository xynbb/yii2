<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\MyUser;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $user = new MyUser();
        //调用模型search方法，把get参数传进去
        $provider = $user->search(YII::$app->request->get());

        return $this->render('index', [
            'model' => $user,
            'provider' => $provider,
        ]);
    }

    public function actionExport() {
        $data = Yii::$app->request->post('MyUser');
        $arrIds = isset($data['id']) && !empty($data['id'])?  $data['id'] : [];
        $str = '';
        $filename = time().'.csv';

        $user = new MyUser();
        $datas = $user->find()->all();

        foreach($arrIds as $arrId) {
            switch($arrId) {
                case 1:
                    $str .='id,';
                    break;
                case 2:
                    $str .='name,';
                    break;
                case 3:
                    $str .='code,';
                    break;
                case 4:
                    $str .='t_status,';
                    break;
            }
        }
        $str .="\n";
        foreach($datas as $key => $val) {
            foreach($arrIds as $arrId) {
                switch($arrId) {
                    case 1:
                        $str .=$val['id'].',';
                        break;
                    case 2:
                        $str .=$val['name'].',';
                        break;
                    case 3:
                        $str .=$val['code'].',';
                        break;
                    case 4:
                        $str .=$val['t_status'].',';
                        break;
                }
            }
            $str .="\n";
        }

        header('Content-Disposition:attachment;filename='.$filename);
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        echo $str;
    }
}
