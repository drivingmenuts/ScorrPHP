<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\BaseController;
use App\Models\PlayerModel;

class Player extends BaseController
{

    private $model;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    )
    {
        parent::initController($request, $response, $logger);
        $this->model = new PlayerModel();
    }

    public function register()
    {
        $name = $this->request->getVar('name');
        $meta = $this->request->getVar('meta');

        log_message('debug', "Received {$name}/{$meta}");

        if ($record = $this->model->where('name', $name)->first()) {
            $rval = [
                'status' => 409,
                'id' => $record['id'],
                'score' => $record['total']
            ];

            log_message('debug', "Record exists!");
        } else {
            $this->model->insert([
                'name' => $name,
                'total' => 0,
                'meta' => json_encode($meta),
            ]);

            $rval = [
                'status' => 201,
                'id' => $this->model->getInsertID()
            ];

            log_message('debug', "Created!");
        }

        return json_encode($rval);
    }

    public function unregister($id)
    {
        $this->model->delete($id);
    }
}
