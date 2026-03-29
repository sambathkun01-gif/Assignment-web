<?php
session_unset();
session_destroy();
header('Location: '.$baseUrl.'?page=login');
exit();
