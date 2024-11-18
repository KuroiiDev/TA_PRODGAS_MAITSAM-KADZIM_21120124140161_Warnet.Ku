<?php
class AccountController
{
    function logout()
    {
        session_start();
        session_destroy();
        header('Location: /warnet.ku/views/login.php');
    }
}
