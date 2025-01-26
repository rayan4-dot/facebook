<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Clone</title>
    <link rel="stylesheet" href="/facebook/assets/css/style.css">
</head>
<body>
    <nav class="main-nav">
        <a href="/" class="nav-brand">Facebook Clone</a>
        <div class="nav-links">
            <?php if (Session::get('user_id')): ?>
                <a href="/dashboard">Dashboard</a>
                <a href="/profile/<?= Session::get('user_id') ?>">Profile</a>
                <a href="/friends">Friends</a>
                <a  href="/logout">Logout</a>
            <?php else: ?>
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <main>