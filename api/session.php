<?php
session_start();

// Check authorization (for example, if there is no user in the session)
if (!isset($_SESSION['user_id'])) {
    // If there is no user in the session, redirect to the login page
    header("Location: ../login_page.html");
    exit();
}
