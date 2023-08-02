<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\ClientModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ClientController extends BaseController
{
    public function index()
    {
        //
    }

    public function create()
    {
        $data['title'] = 'Создание клиента';
        $data['content'] = 'clients/create';
        return view('layout/layout', $data);
    }

    public function store()
    {
        if($this->request->isAJAX()) {
            $client['full_name'] = $this->request->getPost('name', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['gender'] = $this->request->getPost('gender', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['phone'] = $this->request->getPost('phone', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['address'] = $this->request->getPost('address', FILTER_SANITIZE_SPECIAL_CHARS);
            try {
                $newClient = (new ClientModel())->insert($client);
            } catch (DatabaseException $exception)
            {
                $response['msg'] = 'Ошибка создания клиента';
                $response['error'] = $exception->getMessage();
                return $this->response->setJSON($response);
            }
            for ($i = 0; $i < $this->request->getPost('cars'); $i++) {
                $car['brand'] = $this->request->getPost('brand-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['model'] = $this->request->getPost('model-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['color'] = $this->request->getPost('color-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['plate_number'] = $this->request->getPost('plate_number-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['parked'] = 1 ? $this->request->getPost('parked-' . $i) == 'on' : 0;
                $car['owner_id'] = $newClient;
                try {
                    $newCar = (new CarModel())->insert($car);
                } catch (DatabaseException $exception)
                {
                    $response['msg'] = 'Ошибка создания автомобиля';
                    $response['error'] = $exception->getMessage();
                    return $this->response->setJSON($response);
                }
            }
        }
        return $this->response->redirect('/');
    }
}
