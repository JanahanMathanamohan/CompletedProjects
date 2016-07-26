<?php
	// destroies session and redirects
	session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
?>