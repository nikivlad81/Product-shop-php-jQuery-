<?php

use App\Controllers\Content;
use App\Services\Page;

Page::part('head');
$categories = Content::getCategories();
?>
<body>
<?php
Page::part('navbar');
?>
<div class="conteiner">
    <div class="row mt-3">
        <nav class="navbar bg-body-white">
            <div class="container-fluid">
                <a class="navbar-brand"></a>
                <select name="sorting" id="sorting" class="me-5">
                    <option value="sortingByAlphabetically">Sort by Alphabetically</option>
                    <option value="sortingByPrice">Sort by Price</option>
                    <option value="sortingByNewest">Sort by Newest</option>
                </select>
            </div>
        </nav>
        <div class="hstack gap-3">
            <div class="p-2" style="min-width: 20%;">
                <nav class="nav flex-column m-lg-5">
                    <?php foreach ($categories as $category) { ?>
                        <button type="button" id="<?php echo $category['id']; ?>"
                                class="btn btn-secondary mb-2 "
                                style="text-align: left">
                            <?php echo $category['name']; ?> <span
                                    class="badge text-bg-secondary"><?php echo $category['ctn']; ?></span>
                        </button>
                    <?php } ?>
                </nav>
            </div>
            <div class="p-2 ">

                <div class="row" id="content">

                </div>

                <div class="row" id="modal-content">

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