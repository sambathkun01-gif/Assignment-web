<?php
require_once './init/init.php';
$user    = loggedInUser();
$isAdmin = isAdmin();
include './includes/header.inc.php';
include './includes/navbar.inc.php';

$admin_pages      = ['admin/dashboard','admin/movies','admin/movie/create','admin/movie/edit','admin/movie/delete','admin/users','admin/user/create','admin/user/edit','admin/user/delete','admin/reviews'];
$logged_in_pages  = ['dashboard','profile','review/create','review/edit','review/delete'];
$non_logged_pages = ['login','register'];
$public_pages     = ['movie'];
$available_pages  = array_merge($admin_pages,$logged_in_pages,$non_logged_pages,$public_pages,['logout']);

$page = isset($_GET['page']) ? trim($_GET['page']) : '';

if (in_array($page, $logged_in_pages) && empty($user)) {
    header('Location: '.$baseUrl.'?page=login'); exit();
}
if (in_array($page, $non_logged_pages) && !empty($user)) {
    header('Location: '.$baseUrl.'?page=dashboard'); exit();
}
if (in_array($page, $admin_pages) && !$isAdmin) {
    header('Location: '.$baseUrl.'?page=dashboard'); exit();
}

if ($page === '') {
    include './pages/home.php';
} elseif (in_array($page, $available_pages)) {
    $file = './pages/'.$page.'.php';
    if (file_exists($file)) {
        include_once $file;
    } else {
        include './pages/home.php';
    }
} else {
    include './pages/home.php';
}

include './includes/footer.inc.php';
?>
