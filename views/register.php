<?php include 'header.php'; ?>
<div class="container">
    <h2>Register</h2>
    <?php if (isset($error)): ?>
        <div class="alert"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>
<?php include 'footer.php'; ?>