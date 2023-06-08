<?php

    // start session
    session_start();

    // destroy the session and go to customerLogin.php
    if(session_destroy()) {
        header("Location: customerLogin.php");
    }

?>