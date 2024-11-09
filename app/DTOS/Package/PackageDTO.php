<?php
namespace App\DTOS\Package;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\StatusEnum;

class PackageDTO{
    public function __construct(
        public readonly string $name,
        public readonly int $price,
        public readonly int $amount
    )
    {
        
    }

    public static function createFromRequest(PackageStoreRequest $request){

        return new self(
            name:$request->validated('name'),
            price:$request->validated('price'),
            amount:$request->validated('amount')
        );
    } 

}