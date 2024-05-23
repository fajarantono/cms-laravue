<?php

namespace App\Services;

use App\Enums\Ask;
use App\Enums\Role as EnumRole;
use App\Http\Requests\AdministratorRequest;
use App\Http\Requests\PaginateRequest;
use App\Libraries\AppLibrary;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdministratorService
{
    public $user;
    public $userFilter = ['name', 'email', 'username', 'branch_id', 'status'];

    public function list(PaginateRequest $request)
    {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType   = $request->get('order_type') ?? 'desc';

            return User::with('media')->where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->userFilter)) {
                        $query->where($key, 'like', '%' . $request . '%');
                    }
                }
            })->role(EnumRole::ADMIN)->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function show(User $administrator): User
    {
        try {
            if ($administrator->hasRole(EnumRole::ADMIN)) {
                return $administrator;
            } else {
                throw new Exception(trans('The permission is denied.'), 422);
            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function store(AdministratorRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->user = User::create([
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'phone'             => $request->phone,
                    'username'          => AppLibrary::username($request->name),
                    'password'          => Hash::make($request->password),
                    'status'            => $request->status,
                    'email_verified_at' => now(),
                    'branch_id'         => $request->branch_id,
                    'country_code'      => $request->country_code,
                    'is_guest'          => Ask::NO,
                ]);
                $this->user->assignRole(EnumRole::ADMIN);
            });
            return $this->user;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
