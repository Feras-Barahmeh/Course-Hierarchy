@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-edit"></i>
        <span class="">
            <?= $title ?>
        </span>
    </h1>

    <div class="container">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/students/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_students  ?></button>
                </a>
            </div>
        </div>
    </div>
    @extend('layout.messages')@
    <div class="container mt-20 container-form">


        <form class="row g-3" method="POST">
            <div class="col-md-4 input" required>
                <label for="FirstName" class="form-label mb-1"><?= $first_name ?></label>
                <input type="text" class="form-control" id="FirstName" between="2,50" name="FirstName" value="<?= $controller->getStorePost("FirstName", $student) ?>" required autocomplete="none">
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_first_name ?>
                </div>
            </div>

            <div class="col-md-4 input" required>
                <label for="LastName" class="form-label mb-1"><?= $last_name  ?></label>
                <input type="text" class="form-control" id="LastName" between="2,50" name="LastName" value="<?= $controller->getStorePost("LastName", $student) ?>">
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_last_name ?>
                </div>
            </div>



            <div class="col-md-4 input" required>
                <label for="StudentYear" class="form-label mb-1"><?= $text_years ?></label>
                <select class="form-select" id="StudentYear" name="StudentYear" required>
                    <option value=""></option>

                    <?php
                    foreach ($years as $value => $year) {

                        ?>
                        <option <?= $controller::setSelectedAttribute($value, $controller->getStorePost("StudentYear") ) ?>
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






            <div class="col-md-4 input" required>
                <label for="MajorID" class="form-label mb-1"><?= $major_name ?></label>
                <select class="form-select" id="MajorID" name="MajorID" required>

                    <?php
                    foreach ($majors as $major) {

                        ?>
                        <option
                            <?= $controller->setSelectedAttribute( $controller->getStorePost("MajorID"), $major->MajorID ) ?>
                                value="<?= $major->MajorID ?>"
                        >
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


            <div class="col-md-4 ">
                <label for="PhoneNumber" class="form-label mb-1"><?= $phone_number ?></label>
                <input type="number"
                       class="form-control"
                       id="PhoneNumber"
                       name="PhoneNumber"
                       between="0, 165"
                       value="<?= $controller->getStorePost("PhoneNumber", $student) ?>" >

                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>

            <div class="col-md-4 ">
                <label for="Address" class="form-label mb-1"><?= $address ?></label>
                <input type="text"
                       class="form-control"
                       id="Address"
                       name="Address"
                       between="0, 165"
                       value="<?= $controller->getStorePost("Address", $student) ?>" >

                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>



            <div class="col-12">
                <button class="main-btn" name="edit" type="submit"><?= $edit ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@