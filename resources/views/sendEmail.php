<?php
# Include the Autoloader (see "Libraries" for install instructions)
require '../vendor/autoload.php';
use Mailgun\Mailgun;


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


# Instantiate the client.
$mgClient = new Mailgun(env('MAILGUN_API_KEY'));
$domain = env('MAILGUN_DOMAIN');
# Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
	'from'	=> $fromName.' <'. $from .'>',
	'to'	=> $company_name.' <'.$to.'>',
	'subject' => $subject,
    'html'	=> $htmlContent,
    //'o:skip-verification' => 'True'
));
