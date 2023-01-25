<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		
		require_once resource_path('views')."/eproc/registration/master-data-query.php";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		require_once resource_path('views').'/eproc/registration/master-data-query.php';
		
		$user = Auth::user();
		$vendor = get_vendor_login("", "");
		$data = array();
		
		if($vendor) {
			$data = array($vendor);
		} else {
			$data = get_user_login("", "");
		}
		
		//get menu group for user (admin & vendor)
		$get_menu_group = get_menu_group_by_id_user($user->id_user);
		$menu_arr = array();
		foreach ($get_menu_group as $row) {
			array_push($menu_arr, $row['menu_group_object']);	
		}
		session(['menu_group' => $menu_arr]); 
		
		//get user's access group
		$get_acccess_group = get_access_group_by_id_user($user->id_user);
		$access_arr = array();
		foreach ($get_acccess_group as $row) {
			array_push($access_arr, $row['menu_object']);	
		}
		session(['access_group' => $access_arr]);
		
		//var_dump($user->id_user);die;
		//var_dump($data);die;
				
        return view('home', ['user' => $data]);
    }
}
