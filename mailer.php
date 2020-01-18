<?php
    include('functions/phpmail.php');
    function send_email($email, $subject, $msg, $headers) {
        return send_php_mail($email, $subject, $msg, $headers);
    }
    if(send_email("ritwizsinha0@gmail.com","hello test", "hello world", "From: norreply@yourwebsite.com")){
        echo "succes";
    } else {
        echo "failure";
    }
?>