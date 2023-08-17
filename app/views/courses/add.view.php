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
                <a href="/courses/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_course  ?></button>
                </a>
            </div>
        </div>
    </div>
    @extend('layout.messages')@
    <div class="container mt-20 container-form">


        <form class="row g-3" method="POST" >

            <div class="col-md-6 input" required>
                <label for="CourseName" class="form-label mb-1"><?= $course_name ?></label>
                <input type="text" class="form-control" id="CourseName" name="CourseName"  value="<?= $controller->getStorePost("CourseName") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-md-6 input" required>
                <label for="Year" class="form-label mb-1"><?= $text_years ?></label>
                <select class="form-select" id="Year" name="Year" required>
                    <option value=""></option>

                    <?php
                    foreach ($years as $value => $year) {

                        ?>
                        <option <?= $controller::setSelectedAttribute($value, $controller->getStorePost("Year") ) ?>
                                value="<?= $value ?>">
                            <?= $year ?>
                        </option>
                        <?php
                    }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-md-6 input" required>
                <label for="CourseMajorID" class="form-label mb-1"><?= $text_majors ?></label>
                <select class="form-select" id="CourseMajorID" name="CourseMajorID" required>
                    <option value=""></option>
                    
                    <?php
                        foreach ($majors as $major) {

                            ?>
                                <option <?= $controller::setSelectedAttribute($major->MajorID, $controller->getStorePost("CourseMajorID") ) ?>
                                        value="<?= $major->MajorID ?>">
                                    <?= $major->MajorName ?>
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
                <button class="main-btn" name="add" type="submit"><?= $add_course ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@