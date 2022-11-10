<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Hash;
use Session;
use Illuminate\Http\Request;

class BuyerAuthController extends Controller
{
    public function login(){
        return view("inc.login");
    }
    public function registration(){
        return view("inc.registration");
    }
    public function registerBuyer(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:buyers',
            'password'=>'required|min:5|max:12'
        ]);
        $buyer = new Buyer();
        $buyer->name = $request->name;
        $buyer->email = $request->email;
        $buyer->password = Hash::make($request->password);
        $res = $buyer->save();
        if($res){
            return back()->with('success','You have registered successfully');
        }else{
            return back()->with('fail','Something wrong');
        }
    }
    public function loginBuyer(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);
        $buyer = Buyer::where('email','=',$request->email)->first();
        if ($buyer){
            if (Hash::check($request->password, $buyer->password)){
                $request->session()->put('loginId',$buyer->id);
                return redirect('profile');
            }else{
                return back()->with('fail','Password not matches.');
            }
        } else{
            return back()->with('fail','This email is not registered.');
        }
    }
    public function profile()
    {
        $data = array();
        if (Session::has('loginId')){
            $data = Buyer::where('id','=',Session::get('loginId'))->first();
        }
        return view('profile',compact('data'));
    }
    public function logout()
    {
        if (Session::has('loginId')){
            Session::pull('loginId');
            return redirect('/');
        }
    }
}
