@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">

    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
        <span class="">
            <?= $add_college  ?>
        </span>
    </h1>

    @extend('layout.messages')@

    <div class="container mt-20 ">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/colleges/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_college  ?></button>
                </a>
            </div>
        </div>


        <div class="container-form">
            <form class="row g-3" method="POST" >
                <div class="col-md-6">
                    <label for="CollegeName" class="form-label mb-1"><?= $name_college ?></label>
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
                        <?= $name_college_invalid_feedback  ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="TotalStudents" class="form-label mb-1"><?= $count_students ?></label>
                    <input type="number"
                           class="form-control"
                           id="TotalStudents"
                           between="0, 65535"
                           name="TotalStudents"
                           value="<?= $controller->getStorePost("TotalStudents") ?>"
                           required
                    >
                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $number_students_invalid_feedback ?>
                    </div>
                </div>

                <div class="col-12">
                    <button class="main-btn" name="add" type="submit"><?= $add_college ?></button>
                </div>
            </form>
        </div>
    </div>
</main>

@extend('layout.footer')@