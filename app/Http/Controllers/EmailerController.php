<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmailerController extends Controller
{

    public function Index()
    {
        //echo 'starting method';
        return view('welcome');
    }
    public static function Fetch($table, $constrantfieldname = null, $data = null)
    {
        //$results = null;

        if ($constrantfieldname === null or $data === null) {
            $results = DB::select('select * from ' . $table);
        } else {
            $results = DB::select('select * from ' . $table . ' where ' . $constrantfieldname . ' = ' . '\'' . $data . '\'');
            
        }

        //var_dump($results);
        if ($results == null)
            return null;
        elseif (count($results) > 1) {
            return $results;
        } else {
            $result = $results[0];
            return $result;
        }
    }
    public function getAdminData()
    {
        echo 'admin data method';
    }
    public function adminPassword()
    {
        echo 'password method';
    }
}
