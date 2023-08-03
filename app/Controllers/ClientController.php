<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\ClientModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ClientController extends BaseController
{

    public function create()
    {
        $data['title'] = 'Создание клиента';
        $data['content'] = 'clients/create';
        return view('layout/layout', $data);
    }

    public function edit(int $id)
    {
        $client = (new ClientModel())->find($id);
        if($client == null)
        {
            return $this->response->redirect('/');
        }
        $data['title'] = 'Редактирование';
        $data['client'] = $client;
        $data['cars'] = (new CarModel())->where('owner_id='.$id)->findAll();
        $data['content'] = 'clients/edit';
        return view('layout/layout', $data);
    }

    public function update()
    {
        if($this->request->isAJAX()) {
            $clientId = $this->request->getPost('client_id', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['full_name'] = $this->request->getPost('name', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['gender'] = $this->request->getPost('gender', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['phone'] = $this->request->getPost('phone', FILTER_SANITIZE_SPECIAL_CHARS);
            $client['address'] = $this->request->getPost('address', FILTER_SANITIZE_SPECIAL_CHARS);
            try {
                $newClient = (new ClientModel())->update($clientId, $client);
            } catch (DatabaseException $exception) {
                $response['msg'] = 'Ошибка редактирования клиента';
                $response['error'] = $exception->getMessage();
                $this->response->setStatusCode(400);
                return $this->response->setJSON($response);
            }
            for ($i = 0; $i < $this->request->getPost('cars'); $i++) {
                $carId = $this->request->getPost('car-id-'.$i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['brand'] = $this->request->getPost('brand-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['model'] = $this->request->getPost('model-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['color'] = $this->request->getPost('color-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['plate_number'] = $this->request->getPost('plate_number-' . $i, FILTER_SANITIZE_SPECIAL_CHARS);
                $car['parked'] = 1 ? $this->request->getPost('parked-' . $i, FILTER_SANITIZE_SPECIAL_CHARS) == 'on' : 0;
                try {
                    $newCar = (new CarModel())->update($carId, $car);
                } catch (DatabaseException $exception)
                {
                    $response['msg'] = 'Ошибка создания автомобиля';
                    $response['error'] = $exception->getMessage();
                    return $this->response->setJSON($response);
                }
            }
            return $this->response->redirect('/');
        }
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
                $car['parked'] = 1 ? $this->request->getPost('parked-' . $i, FILTER_SANITIZE_SPECIAL_CHARS) == 'on' : 0;
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
