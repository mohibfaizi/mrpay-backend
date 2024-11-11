<?php
namespace App\Services\Package;

use App\DTOS\Package\PackageDTO;
use App\Models\Package;
use App\Services\BaseServices;
class PackageServices extends BaseServices{
    public function index(?int $perPage,string $column,string $sort){
        $package=Package::query();
        return $this->list($package,$perPage,$column,$sort);
    }

    public function store(PackageDTO $packageDTO){
        return Package::create(
            [
                'name'=>$packageDTO->name,
                'price'=>$packageDTO->price,
                'amount'=>$packageDTO->amount
            ]
        );
    }

    public function findByColunName(string $column,mixed $value){
        return Package::where($column,$value)->first();
    }

    public function update(array $data){
        
    }
}