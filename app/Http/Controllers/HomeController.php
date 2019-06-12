<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Flash;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    // paramétres généraux 
    public function settings(Request $request)
    {
        // test for sessions
        // Get the client IP address. $request->ip()
        //Get the client user agent. $request->userAgent()
        $request->session()->put('key', ['value'=>12 ,'isadmin'=> true, 'name'=>'hd',]);
        if ($request->session()->has('key')) {
            // pull --> Retrieving & Deleting An Item from session 
            //echo json_encode($request->session()->pull('key'));
        }
        //dd($request->session()->all());
        return view('settings');
    } 
    // enregistrement des parametre dans .env file 
    public function  update_settings(Request $request)
    {

            // APP_NAME 
            $this->putPermanentEnv('APP_NAME',$request->name);
            // APP_ENV 
            $this->putPermanentEnv('APP_ENV',$request->env);
            //APP_DEBUG
            $this->putPermanentEnv('APP_DEBUG',$request->debug); 
            //APP_URL
            $this->putPermanentEnv('APP_URL',$request->url);
            //APP_LOCALE
            $this->putPermanentEnv('APP_LOCALE',$request->locale);
            //APP_FAKER_LOCALE
            $this->putPermanentEnv('APP_FAKER_LOCALE',$request->faker_locale);
            
            /*
            Data base section
            */

            // DB_HOST
            $this->putPermanentEnv('DB_HOST',$request->host);
            // DB_PORT
             $this->putPermanentEnv('DB_PORT',$request->port);
            // DB_DATABASE
             $this->putPermanentEnv('DB_DATABASE',$request->database);
            // DB_USERNAME
             $this->putPermanentEnv('DB_USERNAME',$request->username);
            // DB_PASSWORD
             if($request->password)
             $this->putPermanentEnv('DB_PASSWORD',$request->password);


           // dd($request->all());
            Flash::success('Configuration enregistré avec succès.');
             return redirect()->back();

    }   
    // paramétres de profile
    public function profileSettings(Request $request)
    {   $user = Auth::user();
        return view('profile_settings',compact('user'));
    }
    // history
    public function history(Request $request)
    {
        return view('history');
    }

    public function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}
