@extends('layouts.app')
@section('content')
<?php

if (count($_POST) == 0) {
    $to = 'user@example.com ';
    $from = 'sender@example.com ';
    $fromName = 'SenderName ';
    $company_name = 'COMPANY NAME';
    $phase_name = 'INSERT PHASE NAME HERE';
    $interval = '$weekly/daily';
    $oppmess = 'we still require some additional items from you until we receve the content nessisary the estimated completion time will keep being pushed. ';
    $comment = 'ADDITIONAL COMMENTS HERE';
    $est_day_left = 'NUMBER DAYS LEFT';

    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers 
    $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
    

} else {
    //var_dump($_POST);
    $to = $_POST['to'];
    $from =  Auth::user()['email'];
    $fromName = Auth::user()['name'];
    $company_name = $_POST['company_name'];
    $phase_name = $_POST['p_name'];
    $interval = 'daily';
    $est_day_left = $_POST['est_day_left'];
    $oppmess = $_POST['delv_content'];
    if ($oppmess == 0){
        $oppmess='We still require some additional items from you. Until we receve the content nessisary the estimated completion time will keep being pushed. ';
    }
    else{
        $oppmess= '';
    }
    $comment = $_POST['comment'];

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers 
    $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
    //post data here
    
}
$subject = "Get Found Update on your Project";

$htmlContent = ' 
    <html> 
    <body><br>
    Dear ' . $company_name . ', <br>
    This is your ' . $interval . ' update we are currently working on ' . $phase_name . '.
    We are currently estimating about '.$est_day_left.' days left.
    '. $comment .' 
    <br>
    '. $oppmess .'
    <br>
    Senerly,
    <br>
    '. $fromName .'

        </body> 
    </html>';


    echo ('To: ' . $to . '<br>From: ' . $fromName . '&lt' . $from . '&gt <br>');
    echo ('Subject: '. $subject. '<br>');
    echo ($htmlContent);
?>
@endsection