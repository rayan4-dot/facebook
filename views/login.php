<?php include 'header.php'; ?>
<div class="login-form">
    <h2>Login</h2>
<!-- views/login.php -->
<form action="/login" method="POST">  <!-- Updated action -->
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
<?php include 'footer.php'; ?> 