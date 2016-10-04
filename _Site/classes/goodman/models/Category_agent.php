<?php
namespace goodman\models;
class Category_agent extends Model
{
    public $pk = "id_category_agent";
    public $table = "category_agent";
    
    public function send_mail($message){

        $mail_to = "blowka07@gmail.com";
        $subject = "Goodman обратная связь";
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf8\r\n"; 
        $headers .= "From: Свяжитесь с клиентом <no-reply@gman.su>"; 
        if (mail($mail_to, $subject, $message, $headers)) return true;
        return false;
    }
}