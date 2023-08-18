@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-check-to-slot"></i>
        <span class="">
            <?= $text_votes ?>
        </span>
    </h1>


    @extend('layout.messages')@

        <div class="container">
            <div class="row mb-20">
                <form action="" class="col-lg-6 col-md-4" METHOD="POST">
                    <div class="input-group flex-nowrap">
                        <button class="input-group-text hover" name="search" type="submit" id="addon-wrapping"><i class="fa fa-filter mr-15 main-color"></i> <?= $search  ?></button>
                        <button class="input-group-text hover" name="resit" type="submit" id="addon-wrapping"><i class="fa fa-arrow-rotate-back mr-15 main-color"></i> <?= $resit ?></button>
                        <input type="text" class="form-control" name="value_search" placeholder="<?= $search_vote  ?>" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                </form>

                <div class="action col-lg-6 col-md-4 d-flex">
                    <a href="/votes/add" class="ml-auto">
                        <button class="btn main-btn"> <i class="fa fa-plus main-color mr-5"></i> <?= $add_vote  ?></button>
                    </a>
                </div>
            </div>




        </div>


</main>

@extend('layout.footer')@