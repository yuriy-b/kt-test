<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;

class CityDataController extends Controller
{
    /**
     * This command get cities and streets info.
     * @return int Exit code
     */

    public function actionIndex()
    {
        $client = new Client();
        $cityResponse = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['citiesApiUrl'])
            ->addHeaders(['secret-token' => Yii::$app->params['secretApiToken']])
            ->send();

        if ($cityResponse->isOk) {
            $command = Yii::$app->db
                ->createCommand()
                ->batchInsert('city', ['name', 'ref'], $cityResponse->data);

            $sql = $command->getRawSql();
            $sql .= ' ON DUPLICATE KEY UPDATE `name`= VALUES(`name`)';

            $command->setRawSql($sql);
            $command->execute();

            foreach ($cityResponse->data as $city) {
                $streetResponse = $client->createRequest()
                    ->setMethod('GET')
                    ->setUrl(Yii::$app->params['streetsApiUrl'])
                    ->addHeaders(['secret-token' => Yii::$app->params['secretApiToken']])
                    ->setData(['city_ref' => $city['ref']])
                    ->send();

                if ($streetResponse->isOk) {
                    $streets = $streetResponse->data;
                    foreach ($streets as &$street) {
                        $street['city_ref'] = $city['ref'];
                    }

                    $command = Yii::$app->db
                        ->createCommand()
                        ->batchInsert('street', ['name', 'ref', 'city_ref'], $streets);

                    $sql = $command->getRawSql();
                    $sql .= ' ON DUPLICATE KEY UPDATE `name`= VALUES(`name`)';

                    $command->setRawSql($sql);
                    $command->execute();
                }
            }

            return ExitCode::OK;
        }

        return ExitCode::UNSPECIFIED_ERROR;
    }
}
