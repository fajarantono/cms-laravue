<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Http\Requests\PaginateRequest;
use App\Services\AdministratorService;
use App\Http\Requests\AdministratorRequest;
use App\Http\Resources\AdministratorResource;

class AdministratorController extends AdminController
{
    private AdministratorService $administratorService;

    public function __construct(AdministratorService $administratorService)
    {
        //parent::__construct();
        $this->administratorService = $administratorService;
    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return AdministratorResource::collection($this->administratorService->list($request));
        } catch (\Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(User $administrator) : AdministratorResource | \Illuminate\Http\Response | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new AdministratorResource($this->administratorService->show($administrator));
        } catch (\Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(AdministratorRequest $request): AdministratorResource | \Illuminate\Http\Response | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new AdministratorResource($this->administratorService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
