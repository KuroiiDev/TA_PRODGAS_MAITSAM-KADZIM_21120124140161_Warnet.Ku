<?php
session_start();
session_destroy();
header('Location: /warnet.ku/views/dashboard.php');