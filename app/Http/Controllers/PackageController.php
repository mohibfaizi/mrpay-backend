<?php

namespace App\Http\Controllers;

use App\DTOS\Package\PackageDTO;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Http\Resources\PackageResource;
use App\Services\Package\PackageServices;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(private PackageServices $packageServices) {}
    public function index(Request $request)
    {
        return PackageResource::collection($this->packageServices->index(
            perPage: $request->perPage,
            column: $request->column ?? "id",
            sort: $request->sort ?? "desc"
        ));
    }
    public function store(PackageStoreRequest $request)
    {
        return $this->packageServices->store(PackageDTO::createFromRequest($request));
    }
    public function show($package)
    {
        return new PackageResource(
            $this->packageServices->findByColunName('id', $package)
        );
    }
    public function update(PackageUpdateRequest $request, $package)
    {
        $data = $request->validated();
        $package = $this->packageServices->findByColunName('id', $package);
        return $package->update($data);
    }
}
