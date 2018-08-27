<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class TrimController extends Controller
{
    /**
     * This command trims zeros after dot
     * @param string $numbers
     * @return int Exit code
     */
    public function actionIndex($numbers = '55.100, 55.01, 50.001, 55.0010, 50.00')
    {
        $rule = '/[.]?[0]+$/';

        $numbers = explode(', ', $numbers);
        foreach ($numbers as $num) {
            echo $num . " -> " . preg_replace($rule, '', $num) . "\n";
        }

        return ExitCode::OK;
    }


}
