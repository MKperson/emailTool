@extends('layouts.app')
@section('content')  
<?php
$to = 'user@example.com '; 
$from = 'sender@example.com '; 
$fromName = 'SenderName '; 
 
$subject = "Get Found Update on your Project"; 
 
$htmlContent = ' 
    <html> 
    <head> 
        <title>Email</title> 
    </head> 
    <body>
    Dear<br> 
    Company Name <br>
    This is your weekly update
    your on INSERT PHASE HERE 


    <br>
    Senerly,
    <br>
    -GetFound




        <!--<table cellspacing="0" > 
            <tr> 
                <th>Name:</th><td>CodexWorld</td> 
            </tr> 
            <tr style="background-color: #e0e0e0;"> 
                <th>Email:</th><td>contact@codexworld.com</td> 
            </tr> 
            <tr> 
                <th>Website:</th><td><a href="http://www.codexworld.com">www.codexworld.com</a></td> 
            </tr> 
        </table> -->
    </body> 
    </html>'; 
 
// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
 
// Additional headers 
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
$headers .= 'Cc: welcome@example.com' . "\r\n"; 
$headers .= 'Bcc: welcome2@example.com' . "\r\n"; 

echo ($headers . $to.'<br><br>' );
echo($subject);
echo($htmlContent);

?>
@endsection  