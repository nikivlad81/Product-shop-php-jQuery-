<?php

use App\Controllers\Content;
use App\Services\Page;
Page::part('head');
$categories = Content::getCategories();

?>
<body>
<?php
Page::part('navbar');
$i = 0;
?>
<div class="conteiner">
    <div class="row mt-3">
        <nav class="navbar bg-body-white">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <form method="get" class="d-flex me-lg-5" role="search">
                    <button type="button" class="btn-group me-1" id="sortingByAlphabetically">Sort by Alphabetically</button>
                    <button type="button" class="btn-group me-1" id="sortingByPrice">Sort by Price</button>
                    <button type="button" class="btn-group me-1" id="sortingByNewest">Sort by Newest</button>
                </form>
            </div>
        </nav>
        <div class="hstack gap-3">
            <div class="p-2" style="min-width: 20%;">
                <nav class="nav flex-column m-lg-5">
                    <?php foreach ($categories as $category) { $i++;?>
                    <button type="button" id="<?php echo $category['id']; ?>" class="btn btn-secondary mb-2 <?php if ($i == 1) { ?> active <?php } ?>" style="text-align: left">
                        <?php echo $category['name']; ?>  <span class="badge text-bg-secondary"><?php echo $category['ctn']; ?></span>
                    </button>
                    <?php } ?>
                </nav>
            </div>
            <div class="p-2 ">

                <div class="row" id="content">

                </div>

            </div>
        </div>
    </div>
</div>
<?php
Page::part('footer');
?>
</body>
</html>