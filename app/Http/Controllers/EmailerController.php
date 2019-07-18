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
    public function update(){
        var_dump($_POST);
        foreach ($_POST as $key => $value) {
           echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
       }
       $cust_array = array('c_email'=>$_POST['c_email'],'c_number'=>$_POST['c_number'],'c_address'=>$_POST['c_address'],'delv_content'=>$_POST['delv_content']);
       var_dump($cust_array);

       $this->handupdate('customer','cust_id',$_POST['cust_id'],$cust_array);
        //  DB::table($table)
        //     ->where($key, $id)
        //     ->update($data);
            //return view('welcome');
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
    public function handupdate($table,$col,$key,$array){
        DB::table($table)
        ->where($col,'=',$key)
        ->update($array);
        return "hand function called";

    }
}
