<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendMail()
    {
        // $details = [
        //     'title' => "Test d'Email ",
        //     'body' => 'Le corps du message de mon email'
        // ];

        Mail::to("yassirali2015@gmail.com")->send(new TestMail());

        return "Email envoyé";

        // ini_set( 'display_errors', 1 );
        // error_reporting( E_ALL );
        // $from = "yassirali2015@gmail.com";
        // $to = "aliyassir859@gmail.com";
        // $subject = "Essai de PHP Mail";
        // $message = "PHP Mail fonctionne parfaitement";
        // // $headers = "From :" . $from;
        // $headers =  'MIME-Version: 1.0' . "\r\n"; 
        // $headers .= 'From: Your name' . $from . "\r\n";
        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
        // mail($to,$subject,$message, $headers);
        // echo "L'email a été envoyé.";
    }
}
