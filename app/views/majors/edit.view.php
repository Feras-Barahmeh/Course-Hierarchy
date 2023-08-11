@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-book-medical"></i>
        <span class="">
            <?= $title ?>
        </span>
    </h1>

    <div class="container">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/majors/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_major  ?></button>
                </a>
            </div>
        </div>
    </div>
    @extend('layout.messages')@
    <div class="container mt-20 container-form">


        <form class="row g-3" method="POST" >

            <div class="col-md-6" >
                <label for="MajorName" class="form-label mb-1"><?= $major_name ?></label>
                <input type="text" class="form-control" id="MajorName" name="MajorName"  value="<?= $controller->getStorePost("MajorName", $major) ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-md-6">
                <label for="NumberHoursMajor" class="form-label mb-1"><?= $number_hours_major ?></label>
                <input type="number" class="form-control" id="NumberHoursMajor" between="132,165" name="NumberHoursMajor" value="<?= $controller->getStorePost("NumberHoursMajor", $major) ?>" required autocomplete="none">
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_number_hours_major ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="CoursesNumber" class="form-label mb-1"><?= $courses_number  ?></label>
                <input type="number" class="form-control" id="CoursesNumber" between="40,85" name="CoursesNumber" value="<?= $controller->getStorePost("CoursesNumber", $major) ?>" required>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_courses_number ?>
                </div>
            </div>


            <div class="col-md-6">
                <label for="MajorDepartmentID" class="form-label mb-1"><?= $text_departments ?></label>
                <select class="form-select" id="MajorDepartmentID" name="MajorDepartmentID" required>
                    <option value=""></option>
                    <?php
                        foreach ($departments as $department) {

                            ?>
                                <option <?= $controller::setSelectedAttribute($department->DepartmentID, $controller->getStorePost("MajorDepartmentID", $major) ) ?>
                                        value="<?= $department->DepartmentID ?>">
                                    <?= $department->DepartmentName ?>
                                </option>
                            <?php
                        }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>




            <div class="col-12">
                <button class="main-btn" name="edit" type="submit"><?= $add_major ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@