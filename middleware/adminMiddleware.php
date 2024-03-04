<?php include('../functions/myfunctions.php');
if (isset($_SESSION['auth'])) {
    if ($_SESSION['role_as'] != 1) {
        redirect("../index.php", "Not Authorized To Visit This Page");
    }
} else {
    redirect('../login.php', 'Login  To Continue');
}
