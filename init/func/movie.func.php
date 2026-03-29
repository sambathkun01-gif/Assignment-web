<?php
function getMovies($search = '', $genre = '') {
    global $db;
    $sql = 'SELECT m.*, ROUND(AVG(r.rating),1) AS avg_rating, COUNT(r.id) AS review_count
            FROM movies m LEFT JOIN reviews r ON m.id = r.movie_id WHERE 1=1';
    $params = []; $types = '';
    if ($search) {
        $sql .= ' AND (m.title LIKE ? OR m.description LIKE ?)';
        $like = "%$search%"; $params[] = $like; $params[] = $like; $types .= 'ss';
    }
    if ($genre) {
        $sql .= ' AND m.genre = ?';
        $params[] = $genre; $types .= 's';
    }
    $sql .= ' GROUP BY m.id ORDER BY m.created_at DESC';
    $q = $db->prepare($sql);
    if ($params) { $q->bind_param($types, ...$params); }
    $q->execute();
    return $q->get_result();
}

function getMovie($id) {
    global $db;
    $q = $db->prepare('SELECT m.*, ROUND(AVG(r.rating),1) AS avg_rating, COUNT(r.id) AS review_count
                       FROM movies m LEFT JOIN reviews r ON m.id = r.movie_id WHERE m.id = ? GROUP BY m.id');
    $q->bind_param('i', $id);
    $q->execute();
    $r = $q->get_result();
    return $r->num_rows ? $r->fetch_object() : null;
}

function getAllMovies() {
    global $db;
    $q = $db->prepare('SELECT m.*, ROUND(AVG(r.rating),1) AS avg_rating, COUNT(r.id) AS review_count
                       FROM movies m LEFT JOIN reviews r ON m.id = r.movie_id GROUP BY m.id ORDER BY m.title');
    $q->execute();
    return $q->get_result();
}

function getGenres() {
    global $db;
    $q = $db->prepare('SELECT DISTINCT genre FROM movies WHERE genre IS NOT NULL AND genre != "" ORDER BY genre');
    $q->execute();
    $rows = $q->get_result();
    $genres = [];
    while ($r = $rows->fetch_object()) $genres[] = $r->genre;
    return $genres;
}

function createMovie($title, $desc, $genre, $release_date, $image) {
    global $db;
    $image_path = null;
    if (!empty($image['name'])) $image_path = uploadImage($image);
    $q = $db->prepare('INSERT INTO movies (title, description, genre, release_date, image) VALUES (?, ?, ?, ?, ?)');
    $rd = $release_date ?: null;
    $q->bind_param('sssss', $title, $desc, $genre, $rd, $image_path);
    $q->execute();
    return $db->affected_rows > 0;
}

function updateMovie($id, $title, $desc, $genre, $release_date, $image) {
    global $db;
    $image_path = null;
    if (!empty($image['name'])) $image_path = uploadImage($image);
    $rd = $release_date ?: null;
    if ($image_path) {
        $q = $db->prepare('UPDATE movies SET title=?, description=?, genre=?, release_date=?, image=? WHERE id=?');
        $q->bind_param('sssssi', $title, $desc, $genre, $rd, $image_path, $id);
    } else {
        $q = $db->prepare('UPDATE movies SET title=?, description=?, genre=?, release_date=? WHERE id=?');
        $q->bind_param('ssssi', $title, $desc, $genre, $rd, $id);
    }
    $q->execute();
    return $db->affected_rows >= 0;
}

function deleteMovie($id) {
    global $db;
    $q = $db->prepare('DELETE FROM movies WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    return $db->affected_rows > 0;
}

function countMovies() {
    global $db;
    return $db->query('SELECT COUNT(*) AS c FROM movies')->fetch_object()->c;
}
