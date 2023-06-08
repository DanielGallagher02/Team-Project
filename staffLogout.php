<?php

    // start session
    session_start();

    // destroy the session and go to staffLogin.php
    if(session_destroy()) {
        header("Location: staffLogin.php");
    }

?>