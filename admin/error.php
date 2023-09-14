<?php
include '../config.php';
include 'parts/header.php';
include 'parts/login-navbar.php';
?>

<div class="error-wrapper">
    <?php if (isset($_GET['message'])) { ?>
        <h1 class="title"><?php echo $_GET['message']; ?></h1>
    <?php } ?>

    <a href="#" class="button-a" onclick="goBack()">Нажмите для возврата</a>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<?php
include 'parts/footer.php';
?>