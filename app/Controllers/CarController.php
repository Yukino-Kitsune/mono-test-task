<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;

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
        elseif ($page > $data['pages']) {
                return $this->response->redirect('/?page='.$data['pages'] - 1);
        }
        $data['data'] = CarModel::getPaginatedData($page);
        $data['currentPage'] = $page;
        return view('layout/layout', $data);
    }

    public function delete()
    {
        $car = new CarModel();
        $id = $this->request->getPost('id');
        $car->delete($id);
        return $this->response->redirect('/');
    }
}
