<?php include 'header.php'; ?>
<div class="login-form">
    <h2>Login</h2>
    <form action="index.php?action=login" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
<?php include 'footer.php'; ?> 