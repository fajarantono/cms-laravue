<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Libraries\AppLibrary;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public string $token;
    public PermissionService $permissionService;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PermissionService $permissionService,
    )
    {
        //$this->middleware('guest')->except('logout');
        $this->permissionService    = $permissionService;
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'errors' => $validator->errors()
            ], 422);
        }

        $request->merge(['status' => Status::ACTIVE]);

        if (!Auth::guard('web')->attempt($request->only('email', 'password', 'status'))) {
            return new JsonResponse([
                'errors' => ['validation' => trans('all.message.credentials_invalid')]
            ], 400);
        }

        $user        = User::where('email', $request['email'])->first();
        $this->token = $user->createToken('auth_token')->plainTextToken;

        if (!isset($user->roles[0])) {
            return new JsonResponse([
                'errors' => ['validation' => trans('all.message.role_exist')]
            ], 400);
        }

        $permission        = PermissionResource::collection($this->permissionService->permission($user->roles[0]));
        $defaultPermission = AppLibrary::defaultPermission($permission);

        return new JsonResponse([
            'message'           => trans('all.message.login_success'),
            'token'             => $this->token,
            'branch_id'         => (int)$user->branch_id,
            'permission'        => $permission,
            'defaultPermission' => $defaultPermission,
        ], 201);
    }
}