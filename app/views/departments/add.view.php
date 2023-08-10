@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">

    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
        <span class="">
            <?= $add_department  ?>
        </span>
    </h1>

    @extend('layout.messages')@

    <div class="container mt-20 ">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/departments/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_department  ?></button>
                </a>
            </div>
        </div>


        <div class="container-form">
            <form class="row g-3" method="POST" >
                <div class="col-md-6 input" required>
                    <label for="DepartmentName" class="form-label mb-1"><?= $name_department ?></label>
                    <input type="text"
                           class="form-control"
                           id="DepartmentName"
                           between="2,100"
                           name="DepartmentName"
                           value="<?= $controller->getStorePost("DepartmentName") ?>"
                           required autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $name_department_invalid_feedback  ?>
                    </div>
                </div>

                <div class="col-md-6 input" required>
                    <label for="CollegeID" class="form-label mb-1"><?= $college ?></label>
                    <select class="form-select" id="CollegeID" name="CollegeID" required>
                        <option selected disabled value="">

                        </option>

                        <?php
                            foreach ($colleges as $college) {
                                ?>
                                <option <?= $controller::setSelectedAttribute($controller->getStorePost("CollegeID"), $college->CollegeID) ?> value="<?= $college->CollegeID ?>"><?= $college->CollegeName ?></option> <?php
                            }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>


                <div class="col-12">
                    <button class="main-btn" name="add" type="submit"><?= $add_department ?></button>
                </div>
            </form>
        </div>
    </div>
</main>

@extend('layout.footer')@