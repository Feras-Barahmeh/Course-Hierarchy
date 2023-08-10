@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">

    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
        <span class="">
            <?= $edit ?> <?= $department->DepartmentName ?> <?= $text_department ?>
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
            <form class="row g-3" method="POST">
                <div class="col-md-6">
                    <label for="DepartmentName" class="form-label mb-1"><?= $new_name_department ?></label>
                    <input type="text"
                           class="form-control"
                           id="DepartmentName"
                           between="2,100"
                           name="DepartmentName"
                           value="<?= $controller->getStorePost("DepartmentName", $department) ?>"
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

                        <?php
                            $select = '';
                            foreach ($colleges as $college) {
                                if ($college->CollegeID == $department->CollegeID) $select = "selected" ;else $select = '';
                                ?>
                                    <option <?= $select ?> value="<?= $college->CollegeID ?>"><?= $college->CollegeName ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>


                <div class="col-12">
                    <button class="main-btn" name="edit" type="submit"><?= $add_department ?></button>
                </div>
            </form>
        </div>
    </div>
</main>

@extend('layout.footer')@