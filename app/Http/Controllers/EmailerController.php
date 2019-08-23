<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Whoops\Exception\ErrorException;
use Psy\Exception\ErrorException as PsyErrorException;
use Illuminate\Support\Facades\Auth;
use Mail;


class EmailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            $results = DB::table($table)->where($constrantfieldname, $data)->get();
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
    public function update()
    {
        //var_dump($_POST);
        /*foreach ($_POST as $key => $value) {
           echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
       }*/
        $c_email = $this->clean_data($_POST['c_email']);
        $c_number = $this->clean_data($_POST['c_number']);
        $c_address = $this->clean_data($_POST['c_address']);
        $delv_content = $this->clean_data($_POST['delv_content']);

        $p_comment = $this->clean_data($_POST['p_comment']);
        $est_day_left = $this->clean_data($_POST['est_day_left']);

        $valid_array = array('c_email' => $c_email, 'c_number' => $c_number, 'est_day_left' => $est_day_left);

        $cust_array = array('c_email' => $c_email, 'c_number' => $c_number, 'c_address' => $c_address, 'delv_content' => $delv_content);
        //var_dump($cust_array);
        $phase_array = array('p_comment' => $p_comment, 'est_day_left' => $est_day_left);
        //$cur_phase = $this->Fetch('c_phase','p_name',$_POST['p_name']);

        if ($this->validate_data($valid_array)['code'] == '404') {
            echo json_encode($this->validate_data($valid_array));
        } else {
            echo json_encode($this->validate_data($valid_array));

            //return $this->validate_data($valid_array);
            //else return true;

            //var_dump($phase_array);

            $this->handupdate('customer', 'cust_id', $_POST['cust_id'], $cust_array);
            $this->handupdate('c_phase', 'phase_id', $_POST['cur_phase'], $phase_array);

            //  DB::table($table)
            //     ->where($key, $id)
            //     ->update($data);
            //return view('welcome');
            //echo var_dump($data);

            //return view('welcome'); 
            //return "update called.";
        }
    }
    public function template()
    {
        //var_dump($_POST);
        return view('template', $_POST);
    }

    public function reload()
    {
        //var_dump($_POST);
        $cur_phase = DB::select('select * from c_phase where cust_id  = ' . $_POST['cust_id'] . ' and p_name = \'' . $_POST['p_name'] . '\'');
        $curarray = array('cur_phase' => $cur_phase[0]->phase_id);
        var_dump($curarray);
        //*
        DB::table('customer')
            ->where('cust_id', '=', $_POST['cust_id'])
            ->update($curarray);
        //*/
        //var_dump($cur_phase);
        return 'reload called';
    }
    public function handupdate($table, $col, $key, $array)
    {
        DB::table($table)
            ->where($col, '=', $key)
            ->update($array);
        //return "hand function called";

    }
    public function sendEmail()
    {

        //Can use post method with below vars to skip the button on client view

        $to = $_POST['to'];
        $from =  Auth::user()['email'];
        $fromName = Auth::user()['name'];
        $company_name = $_POST['company_name'];
        $phase_name = $_POST['p_name'];
        $interval = 'daily';
        $est_day_left = $_POST['est_day_left'];
        $oppmess = $_POST['delv_content'];
        if ($oppmess == 0) {
            $oppmess = 'We still require some additional items from you. Until we receve the content nessisary the estimated completion time will keep being pushed. ';
        } else {
            $oppmess = '';
        }
        $comment = $_POST['comment'];

        $subject = "Get Found Update on your Project";

        $htmlContent = ' 
    
    <br>
    Dear ' . $company_name . ', <br>
    This is your ' . $interval . ' update we are currently working on ' . $phase_name . '.
    We are currently estimating about ' . $est_day_left . ' days left.
    ' . $comment . ' 
    <br>
    ' . $oppmess . '
    <br>
    Senerly,
    <br>
    ' . $fromName . '
        
    ';


        $data = array('to' => $to, 'from' => $from, 'fromname' => $fromName, 'content' => $htmlContent, 'title' => $subject);


        Mail::send(['html' => 'emails.send'], $data, function ($message) use ($data) {
            $message->subject($data['title']);
            $message->from($data['from'], $data['fromname']);
            $message->to($data['to']);
        });


        return response()->json(['message' => 'Request completed']);



        //return view('sendEmail', $_POST);
    }
    public function client()
    {

        if ($_POST["formCustomer"] === "") {
            return redirect('/');
        } else
            return view('client', $_POST);
    }
    protected function clean_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    protected function validate_data($array)
    {
        $errorMSG = "";

        /* EMAIL */
        if (empty($array["c_email"])) {
            $errorMSG .= "<li>Email is required</li>";
        } else if (!filter_var($array["c_email"], FILTER_VALIDATE_EMAIL)) {
            $errorMSG .= "<li>Invalid email format</li>";
        } else {
            $email = $array["c_email"];
        }

        /* PHONE */
        if (empty($array["c_number"])) {
            $errorMSG .= "<li>Phone number is required</li>";
        } else if ($this->validate_phone_number($array["c_number"]) == false) {
            $errorMSG .= "<li>Invalid phone format</li>";
        } else {
            $phone = $array["c_number"];
        }
        /* est_day_left */
        if (empty($array["est_day_left"])) {
            $errorMSG .= "<li>Number days is required</li>";
        } else if (!filter_var($array["est_day_left"], FILTER_VALIDATE_INT)) {
            $errorMSG .= "<li>Invalid Day entry format</li>";
        } else {
            $day_left = $array["est_day_left"];
        }

        if (empty($errorMSG)) {
            $msg = " Email: " . $email . ', Phone: ' . $phone . ', Days_left: ' . $day_left;
            return ['code' => 200, 'msg' => $msg];
            exit;
        }

        return ['code' => 404, 'msg' => $errorMSG];
    }
    protected function validate_phone_number($phone)
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return true;
        }
    }
}
