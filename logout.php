<?php

    session_start(); // Start Session
    
    session_unset(); // End Session
    
    session_destroy(); // Session Unset
    
    header('location: index.php');