<div class="row mb-20 gap-10">
    <form action="" class="col-lg-8 col-md-12" METHOD="POST">
        <div class="input-group flex-nowrap">
            <button class="input-group-text hover" name="search" type="submit" id="addon-wrapping"><i class="fa fa-filter mr-15 main-color"></i> <?= $search  ?></button>
            <button class="input-group-text hover" name="resit" type="submit" id="addon-wrapping"><i class="fa fa-arrow-rotate-back mr-15 main-color"></i> <?= $resit ?></button>
            <input type="text" class="form-control" name="value_search" placeholder="<?= $search_placeholder  ?>" aria-label="" aria-describedby="addon-wrapping">
        </div>
    </form>

    <div class="action col-lg-3 col-md-12 d-flex">
        <a href="/<?= $controller->getController() ?>/add" class="">
            <button class="btn main-btn"> <i class="fa fa-plus main-color mr-5"></i> <?= $controller->language->getDictionary()["add"]  ?></button>
        </a>
    </div>
</div>

