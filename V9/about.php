<?php
include ('server.php');

$msg = "this is a test";

$msg = wordwrap($msg,70);

mail("callumwakefield@riccarton.school.nz", "test", $msg);


?>