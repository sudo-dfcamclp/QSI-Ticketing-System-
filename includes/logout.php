<?php

// Hiwalay na session name para sa Ticketing system — para
// hindi mag-share ng session cookie/state sa ibang app
// (hal. epayroll) na naka-host din sa parehong domain.
session_name('ticketing_session');
session_start();
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;