<?php

use App\Services\Database;
use App\Services\Page;
Page::part('head');
?>
<body>
<?php
Page::part('navbar');

$check = 1;
if ($_GET['check'] == null) {
    $database = new Database;

    $pdo = $database::start();
    $check = $pdo->query('SHOW TABLES LIKE "categories"');
    $check = $check->rowCount();
    $_GET['check'] = true;
}

?>
<div class="container">
    <?php if ($check == 0) { ?>
    <div class="card mt-5">
        <div class="card-header bg-dark-subtle">
            Welcome!
        </div>
        <div class="card-body ">
            <form action="/create/contant" method="post">
                <h5 class="card-title">Content is missing.</h5>
                <p class="card-text">Create content to display. Make sure the database is created!</p>
                <button type="submit" class="btn btn-primary">Create content</button>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="card mt-5">
        <div class="card-header bg-dark-subtle">
            Welcome!
        </div>
        <div class="card-body ">
             <h5 class="card-title">Content created.</h5>
             <p class="card-text">Now you can go to the shop.</p>
             <button type="button" class="btn btn-primary"><a href="/shop?category=1&sort=sortingByNewest" style="color: white; text-decoration: none;">Shop!</a></button>
        </div>
    </div> <?php } ?>
</div>

</body>
</html>