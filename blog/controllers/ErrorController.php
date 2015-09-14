<?php

namespace wap\controllers;

use blog\controllers\common\BaseController;
use blog\controllers\common\BlogException;
use Yii;
use yii\log\FileTarget;

class ErrorController extends BaseController
{
    public function actionError() {

        $code = 404;
        $msg = BlogException::OBJECT_NOT_FOUND;
        $error = Yii::$app->errorHandler->exception;
        if ($error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            $file = $error->getFile();
            $line = $error->getLine();

            $time = microtime(true);
            $log = new FileTarget();
            $log->logFile = Yii::$app->getRuntimePath() . '/logs/err.log';
            $log->messages[] = [
                $msg . " [file: {$file}][line: {$line}][err code:$code.][url:{$_SERVER['REQUEST_URI']}][post:".http_build_query($_POST)."]",
                1,
                'application',
                $time
            ];
            $log->export();
            $code = -1;
            $msg = "系统错误，请稍后重试";
        }
        $this->goHome();
    }
}

