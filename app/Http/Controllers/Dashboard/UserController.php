<?php 
namespace App\Http\Controllers\Dashboard;

use App\User;
use App\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function index(Request $request)
	{
		$users = User::orderBy('user_name');

		$isEmployee = $request->input('employee');
		if($isEmployee) {
			$users = $users->has('permission');
		}

		$userName = $request->input('user_name');
		if(strlen($userName) > 2) {
			$users = $users->where('user_name','like',"%$userName%");
		}

		$userPermissions = $request->input('permissions');
		if($userPermissions) {
			$users = User::usersWithPermissions($userPermissions, $users);
		}

		$perPage = $request->input('per_page') ?: 10;
		$users = $users->simplePaginate($perPage);

		$users->appends($request->query());

		$request->flash();
		return view('dashboard.users.index', [
			'users'			=> $users,
			'permissions'	=> Permission::PERMISSIONS,
		]);
	}

	//update permissions
	public function update(Request $request, User $user)
	{
		$this->authorize('update', User::class);
		if(!$user) return redirect()->back();

		$this->validate($request, [
			'permissions' => 'required|array',
		]);
		
		$permissions = $request->input('permissions');
		$update = array_reduce(Permission::PERMISSIONS,
			function($result, $item) use($permissions) {
				$result[$item] = in_array($item, $permissions) ? 1 : 0;
				return $result;
			}
		);

		if($user->isEmployee()) {
			$user->permission()
				->first()
				->update($update);
		} else {
			$user->permission()
				->save(
					new Permission($update)	
				);
		}	
		
		return redirect()->back();
	}
}