<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\ClientModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class CarController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Список';
        $data['content'] = 'cars/index';
        $data['pages'] = CarModel::getPagesCount();
        $page = $this->request->getGet('page') ? $this->request->getGet('page') : 1;
        if($page < 1) {
            return $this->response->redirect('/?page=1');
        }
        elseif ($page > $data['pages'] && $data['pages'] > 0) {
                return $this->response->redirect('/?page='.$data['pages'] - 1);
        }
        $data['data'] = CarModel::getPaginatedData($page);
        $data['currentPage'] = $page;
        return view('layout/layout', $data);
    }

    public function store()
    {
        if($this->request->isAJAX()) {
            $newCar['brand'] = $this->request->getPost('brand', FILTER_SANITIZE_SPECIAL_CHARS);
            $newCar['model'] = $this->request->getPost('model', FILTER_SANITIZE_SPECIAL_CHARS);
            $newCar['color'] = $this->request->getPost('color', FILTER_SANITIZE_SPECIAL_CHARS);
            $newCar['plate_number'] = $this->request->getPost('plate_number', FILTER_SANITIZE_SPECIAL_CHARS);
            $newCar['parked'] = $this->request->getPost('parked', FILTER_SANITIZE_SPECIAL_CHARS);
            $newCar['owner_id'] = $this->request->getPost('owner_id', FILTER_SANITIZE_SPECIAL_CHARS);
            try {
                $car = (new CarModel())->insert($newCar);
            } catch (DatabaseException $exception) {
                $data['msg'] = 'Ошибка добавления автомобиля';
                $data['error'] = $exception->getMessage();
                $this->response->setStatusCode(400);
                return $this->response->setJSON($data);
            }
            $data['msg'] = 'Добавление автомобиля успешно';
            $data['id'] = $car;
            return $this->response->setJSON($data);
        }
    }

    public function delete()
    {
        $car = new CarModel();
        $id = $this->request->getPost('id');
        $car->delete($id);
        if($this->request->isAJAX()) {
            return $this->response->send();
        }
        return $this->response->redirect('/');
    }

    public function report()
    {
        $data['title'] = 'Список припаркованных';
        $data['content'] = 'cars/report';
        $data['data'] = CarModel::getParkedCars();
        $data['clients'] = ClientModel::getAll();
        return view('layout/layout', $data);
    }

    public function park()
    {
        $parkStatus = 0;
        if($this->request->isAJAX()) {
            $parkStatus = 1;
        }
        $id = $this->request->getPost('car_id',FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            (new CarModel())->update($id, ['parked' => $parkStatus]);
        } catch (DatabaseException $exception) {
            $data['msg'] = 'Ошибка';
            $data['error'] = $exception->getMessage();
            $this->response->setStatusCode(400);
            return $this->response->setJSON($data);
        }
        return $this->response->redirect('/report');
    }

    public function getClientsCars()
    {
        if($this->request->isAJAX()) {
            $client_id = $this->request->getGet('client_id', FILTER_SANITIZE_SPECIAL_CHARS);
            $cars = CarModel::getCarByClient($client_id);
            return $this->response->setJSON($cars);
        }
    }
}
