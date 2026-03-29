<?php
function getMovieReviews($movie_id) {
    global $db;
    $q = $db->prepare('SELECT r.*, u.name AS user_name, u.username, u.photo AS user_photo
                       FROM reviews r JOIN users u ON r.user_id = u.id
                       WHERE r.movie_id = ? ORDER BY r.created_at DESC');
    $q->bind_param('i', $movie_id);
    $q->execute();
    return $q->get_result();
}

function getUserReviews($user_id) {
    global $db;
    $q = $db->prepare('SELECT r.*, m.title AS movie_title, m.genre, m.image AS movie_image
                       FROM reviews r JOIN movies m ON r.movie_id = m.id
                       WHERE r.user_id = ? ORDER BY r.created_at DESC');
    $q->bind_param('i', $user_id);
    $q->execute();
    return $q->get_result();
}

function getAllReviews() {
    global $db;
    $q = $db->prepare('SELECT r.*, u.username, m.title AS movie_title
                       FROM reviews r JOIN users u ON r.user_id = u.id JOIN movies m ON r.movie_id = m.id
                       ORDER BY r.created_at DESC');
    $q->execute();
    return $q->get_result();
}

function getUserReviewForMovie($user_id, $movie_id) {
    global $db;
    $q = $db->prepare('SELECT * FROM reviews WHERE user_id = ? AND movie_id = ?');
    $q->bind_param('ii', $user_id, $movie_id);
    $q->execute();
    $r = $q->get_result();
    return $r->num_rows ? $r->fetch_object() : null;
}

function getReview($id) {
    global $db;
    $q = $db->prepare('SELECT * FROM reviews WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    $r = $q->get_result();
    return $r->num_rows ? $r->fetch_object() : null;
}

function createReview($user_id, $movie_id, $rating, $comment) {
    global $db;
    $q = $db->prepare('INSERT INTO reviews (user_id, movie_id, rating, comment) VALUES (?, ?, ?, ?)');
    $q->bind_param('iiis', $user_id, $movie_id, $rating, $comment);
    $q->execute();
    return $db->affected_rows > 0;
}

function updateReview($id, $rating, $comment) {
    global $db;
    $q = $db->prepare('UPDATE reviews SET rating=?, comment=? WHERE id=?');
    $q->bind_param('isi', $rating, $comment, $id);
    $q->execute();
    return $db->affected_rows >= 0;
}

function deleteReview($id) {
    global $db;
    $q = $db->prepare('DELETE FROM reviews WHERE id = ?');
    $q->bind_param('i', $id);
    $q->execute();
    return $db->affected_rows > 0;
}

function countReviews() {
    global $db;
    return $db->query('SELECT COUNT(*) AS c FROM reviews')->fetch_object()->c;
}

function renderStars($rating) {
    $out = '';
    for ($i = 1; $i <= 5; $i++) {
        $out .= $i <= $rating
            ? '<i class="bi bi-star-fill text-warning"></i>'
            : '<i class="bi bi-star text-warning"></i>';
    }
    return $out;
}
