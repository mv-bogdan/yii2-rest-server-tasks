<?php

namespace api\controllers\v1;

use Yii;
use yii\web\Controller;


class RestController extends Controller
{

    public $request;

    public $enableCsrfValidation = false;

    public $headers;


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => []
            ]

        ];
        return $behaviors;
    }

    public function init()
    {
        $this->request = json_decode(file_get_contents('php://input'), true);

        if($this->request&&!is_array($this->request)){
            Yii::$app->api->sendFailedResponse(['Invalid Json']);

        }

    }

}


