<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BranchRequest;
use Exception;
use App\Models\Branch;
use App\Http\Requests\PaginateRequest;
use App\Services\BranchService;
use App\Http\Resources\BranchResource;
use \Illuminate\Http\Response;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\Routing\ResponseFactory;

class BranchController extends AdminController
{
    public BranchService $branchService;

    public function __construct(BranchService $branch)
    {
        parent::__construct();
        $this->branchService = $branch;
    }

    public function index(PaginateRequest $request): Response | AnonymousResourceCollection | Application | ResponseFactory
    {
        try {
            return BranchResource::collection($this->branchService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Branch $branch): BranchResource | Response | Application | ResponseFactory
    {
        try {
            return new BranchResource($this->branchService->show($branch));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(BranchRequest $request): BranchResource | Response | Application | ResponseFactory
    {
        try {
            return new BranchResource($this->branchService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(BranchRequest $request, Branch $branch): BranchResource | Response |Application | ResponseFactory
    {
        try {
            return new BranchResource($this->branchService->update($request, $branch));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Branch $branch): Response | Application | ResponseFactory
    {
        try {
            $this->branchService->destroy($branch);
            return response(['status' => true, 'message' => ''], 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
