<?php
function usernameExists($username) {
    global $db;
    $q = $db->prepare('SELECT id FROM users WHERE username = ?');
    $q->bind_param('s', $username);
    $q->execute();
    return $q->get_result()->num_rows > 0;
}

function emailExists($email) {
    global $db;
    $q = $db->prepare('SELECT id FROM users WHERE email = ?');
    $q->bind_param('s', $email);
    $q->execute();
    return $q->get_result()->num_rows > 0;
}

function registerUser($name, $username, $email, $passwd) {
    global $db;
    $hashed = password_hash($passwd, PASSWORD_DEFAULT);
    $q = $db->prepare('INSERT INTO users (name, username, email, passwd) VALUES (?, ?, ?, ?)');
    $q->bind_param('ssss', $name, $username, $email, $hashed);
    $q->execute();
    return $db->affected_rows > 0;
}

function loginUser($username, $passwd) {
    global $db;
    $q = $db->prepare('SELECT * FROM users WHERE username = ?');
    $q->bind_param('s', $username);
    $q->execute();
    $result = $q->get_result();
    if ($result->num_rows) {
        $user = $result->fetch_object();
        // Support plain-text passwords (legacy) AND hashed
        if (password_verify($passwd, $user->passwd) || $passwd === $user->passwd) {
            return $user;
        }
    }
    return false;
}

function loggedInUser() {
    global $db;
    if (!isset($_SESSION['user_id'])) return null;
    $id = $_SESSION['user_id'];
    $q  = $db->prepare('SELECT * FROM users WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    $r = $q->get_result();
    return $r->num_rows ? $r->fetch_object() : null;
}

function isAdmin() {
    $user = loggedInUser();
    return $user && $user->role === 'admin';
}

function isUserHasPassword($passwd) {
    $user = loggedInUser();
    return password_verify($passwd, $user->passwd) || $passwd === $user->passwd;
}

function setUserNewPassword($passwd) {
    global $db;
    $user   = loggedInUser();
    $hashed = password_hash($passwd, PASSWORD_DEFAULT);
    $q = $db->prepare('UPDATE users SET passwd = ? WHERE id = ?');
    $q->bind_param('si', $hashed, $user->id);
    $q->execute();
    return $db->affected_rows > 0;
}

function uploadImage($image) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext     = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed))  throw new Exception('File type not allowed. Use JPG, PNG or GIF.');
    if ($image['error'] > 0)        throw new Exception('Upload error: ' . $image['error']);
    if ($image['size'] > 2000000)   throw new Exception('File too large (max 2MB).');
    $dir      = './assets/images/';
    $filename = uniqid('Image-') . '.' . $ext;
    move_uploaded_file($image['tmp_name'], $dir . $filename);
    return $dir . $filename;
}

function getUserImage($id) {
    global $db;
    $q = $db->prepare('SELECT photo FROM users WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    $r = $q->get_result()->fetch_object();
    return $r ? $r->photo : null;
}
?>
