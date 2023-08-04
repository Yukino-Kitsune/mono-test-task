<?php

namespace App\Models;

use App\Database\Migrations\Cars;
use CodeIgniter\Model;

class CarModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cars';
    protected $primaryKey       = 'car_id'; // manual edit
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['brand', 'model', 'color', 'plate_number', 'parked', 'owner_id']; // manual edit

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    private static int $recordPerPage = 10;
    static function getPaginatedData(int $page = 1)
    {
        $cars = new CarModel();
        return $cars->select('car_id, brand, model, client_id, full_name, phone')
            ->join('clients', 'cars.owner_id = clients.client_id')
            ->limit(self::$recordPerPage, self::$recordPerPage * ($page - 1))
            ->find();
    }

    static function getPagesCount()
    {
        $cars = new CarModel();
        return ceil($cars->countAllResults() / self::$recordPerPage);
    }

    static function getParkedCars()
    {
        $cars = new CarModel();
        return $cars->select('car_id, brand, model, client_id, full_name, phone')
            ->join('clients', 'cars.owner_id = clients.client_id')
            ->where('parked = 1')
            ->findAll();
    }

    static function getCarByClient(int $id)
    {
        $cars = new CarModel();
        return $cars->where('owner_id = '.$id)
                    ->where('parked = 0')
                    ->findAll();
    }

}
