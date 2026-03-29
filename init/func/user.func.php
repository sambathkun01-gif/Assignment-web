<?php
function getUsers() {
    global $db;
    $q = $db->prepare("SELECT * FROM users WHERE role <> 'admin' ORDER BY created_at DESC");
    $q->execute();
    return $q->get_result();
}

function getAllUsers() {
    global $db;
    $q = $db->prepare("SELECT * FROM users ORDER BY created_at DESC");
    $q->execute();
    return $q->get_result();
}

function readUser($id) {
    global $db;
    $q = $db->prepare('SELECT * FROM users WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    $r = $q->get_result();
    return $r->num_rows ? $r->fetch_object() : null;
}

function deleteUser($id) {
    global $db;
    $q = $db->prepare('DELETE FROM users WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    return $db->affected_rows > 0;
}

function updateUser($id, $name, $username, $email, $passwd, $photo) {
    global $db;
    $image_path = null;
    if (!empty($photo['name'])) {
        $image_path = uploadImage($photo);
    }
    if (!empty($passwd)) {
        $hashed = password_hash($passwd, PASSWORD_DEFAULT);
        if ($image_path) {
            $q = $db->prepare('UPDATE users SET name=?, username=?, email=?, passwd=?, photo=? WHERE id=?');
            $q->bind_param('sssssi', $name, $username, $email, $hashed, $image_path, $id);
        } else {
            $q = $db->prepare('UPDATE users SET name=?, username=?, email=?, passwd=? WHERE id=?');
            $q->bind_param('ssssi', $name, $username, $email, $hashed, $id);
        }
    } else {
        if ($image_path) {
            $q = $db->prepare('UPDATE users SET name=?, username=?, email=?, photo=? WHERE id=?');
            $q->bind_param('ssssi', $name, $username, $email, $image_path, $id);
        } else {
            $q = $db->prepare('UPDATE users SET name=?, username=?, email=? WHERE id=?');
            $q->bind_param('sssi', $name, $username, $email, $id);
        }
    }
    $q->execute();
    return $db->affected_rows >= 0;
}

function createUserAdmin($name, $username, $email, $passwd, $photo) {
    global $db;
    $image_path = null;
    if (!empty($photo['name'])) $image_path = uploadImage($photo);
    $hashed = password_hash($passwd, PASSWORD_DEFAULT);
    $q = $db->prepare('INSERT INTO users (name, username, email, passwd, photo) VALUES (?, ?, ?, ?, ?)');
    $q->bind_param('sssss', $name, $username, $email, $hashed, $image_path);
    $q->execute();
    return $db->affected_rows > 0;
}
?>
