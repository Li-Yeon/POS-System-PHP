<?php

session_start();
session_unset();
session_destroy();
unset($_SESSION['currentUser']);

echo '<script>location.href="../index.php"</script>';
?>