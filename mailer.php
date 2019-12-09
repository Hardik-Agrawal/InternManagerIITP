<?php
    function send_email($email, $subject, $msg, $headers) {
        return mail($email, $subject, $msg, $headers);
    }
    if(send_email("ashyadavash@gmail.com","hello test", "hello world", "From: norreply@yourwebsite.com")){
        echo "succes";
    } else {
        echo "failure";
    }
?>