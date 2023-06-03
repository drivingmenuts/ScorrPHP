<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\BaseController;
use App\Models\ScoreModel;

use CodeIgniter\CLI\CLI;
use CodeIgniter\I18n\Time;

class Score extends BaseController
{

    private $model;

    public function initController(
        RequestInterface  $request,
        ResponseInterface $response,
        LoggerInterface   $logger
    )
    {
        parent::initController($request, $response, $logger);
        $this->model = new ScoreModel();
    }

    public function register()
    {

        $id = $this->request->getVar('id');
        $score = $this->request->getVar('score');
        $meta = $this->request->getVar('meta');

        log_message('debug', "Received {$id}/{$score}}/{$meta}");
        CLI::write("Received {$id}/{$score}}/{$meta}");

        try {
            $this->model->insert([
                'player_id' => $id,
                'score' => $score,
                'meta' => json_encode($meta),
                'collected' => false,
                'created_at' => microtime(true)
            ]);

            $rval = [
                'status' => 201
            ];
        } catch (\Exception $e) {

            log_message('error', $e->getMessage());

            $rval = [
                'status' => 500
            ];
        }

        return json_encode($rval);
    }
}
