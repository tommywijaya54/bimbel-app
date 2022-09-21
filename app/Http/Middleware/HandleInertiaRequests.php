<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'permissions' => function () use ($request) {
                    if ($request->user()) {
                        $user = $request->user();

                        $permissions = $user->getPermissionsViaRoles()->pluck('name');

                        // $user->givePermissionTo('create-users');
                        // $user->getAllPermissions->pluck('name');;
                        //$permissions = $user->getAllPermissions();
                        // dd($user->getAllPermissions());
                        // return $permissions;

                        return $permissions;
                    }
                    return null;
                },
                'roles' => function () use ($request) {
                    if ($request->user()) {
                        $user = $request->user();
                        return $user->roles()->pluck('name');
                    }
                }
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => $request->session()->get('message'),
            ],
        ]);
    }
}
