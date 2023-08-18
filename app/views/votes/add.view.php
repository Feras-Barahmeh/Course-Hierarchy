@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">

    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
        <span class="">
            <?= $add_votes  ?>
        </span>
    </h1>

    @extend('layout.messages')@

    <div class="container mt-20 ">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/votess/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_votes  ?></button>
                </a>
            </div>
        </div>


        <div class="container-form">
            <form class="row g-3" method="POST" >
                <div class="col-md-12">
                    <label for="CollegeName" class="form-label mb-1"><?= $name_votes ?></label>
                    <input type="text"
                           class="form-control"
                           id="CollegeName"
                           between="4,100"
                           name="CollegeName"
                           value="<?= $controller->getStorePost("CollegeName") ?>"
                           required autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $name_votes_invalid_feedback  ?>
                    </div>
                </div>


                <div class="col-12">
                    <button class="main-btn" name="add" type="submit"><?= $add_votes ?></button>
                </div>
            </form>
        </div>
    </div>
</main>

@extend('layout.footer')@