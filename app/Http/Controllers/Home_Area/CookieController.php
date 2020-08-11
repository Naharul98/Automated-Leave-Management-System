<?php

namespace App\Http\Controllers\Home_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{

	/*
	If a cookie with name 'session_select_id' does not exist or is empty, this cookie is inserted with the number in id
	If such a cookie does exist, the number in id is appended to the end with a ", " character. So if requests with id 1,
	then 2, then 3 comes in, a cookie with value 1, 2, 3 will be inserted
	*/
	public function insertCookie(Request $request, $id)
	{

		if($id == 0){ //there can be no session with an id of 0, so it is chosen as the id that deletes the current cookie
			Cookie::queue(Cookie::forget('session_select_id'));
			return $this->goToLoginPage();
		}else if(strpos(Cookie::get('session_select_id'),$id)){ //check if this session already exists
			return $this->goToLoginPage();
		}else{
			if(strlen(Cookie::get('session_select_id'))>0 && $id!==Cookie::get('session_select_id')){ //if there is already a session in the cookie
				Cookie::queue('session_select_id', Cookie::get('session_select_id').", ".$id, 999); //append this new session at the end of the cookie with a ", " character
			}else{
				Cookie::queue('session_select_id', $id, 999); //otherwise only append the is to the cookie
			}
		}

		return $this->goToLoginPage();
	}

	public function goToLoginPage(){
		return view('auth.login');
	}

	/*
	Converts a cookie with format 1, 2, 3 into an array with value [1,2,3]
	*/
	public function cookieToArray(){
		if(strlen(Cookie::get('session_select_id'))>0){
			$arr = explode(", ",Cookie::get('session_select_id')); //convert the cookie into an array
		}

		$returnArray = array_unique($arr); //remove all duplicate characters from the array
		return $this->goToLoginPage();
	}

	/*
	Deletes the value of $id from a cookie with a format as shown in insertCookie()
	*/
	public function deleteCookie(Request $request, $id){
		$arr = explode(", ",Cookie::get('session_select_id'));

		$arrDiff = array_diff( $arr, [$id] ); //removes id from the array, if it exists

		Cookie::queue('session_select_id', implode( ", ", $arrDiff ), 999); //converts the array back into a comma separated list

		return redirect('/user_area/index')->with('success', 'opted out from session successfully');
	}
}
