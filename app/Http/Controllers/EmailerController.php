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
            //$results = DB::select('select * from ' . $table);
            $results = DB::table($table)->get();

        
        } else {
            //$results = DB::select('select * from ' . $table . ' where ' . $constrantfieldname . ' = ' . '\'' . $data . '\'');
            $results = DB::table($table)->where($constrantfieldname, $data )->get();
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
    public static function update(){
        foreach ($_POST as $key => $value) {
           echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        }
        // DB::table($table)
        //     ->where('id', $id)
        //     ->update($data);
        //     return view('welcome');
        //echo var_dump($data);
        //return view('welcome');
        return "function called.";
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
