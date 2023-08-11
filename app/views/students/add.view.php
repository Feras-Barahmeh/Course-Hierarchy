@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
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


        <form class="row g-3" method="POST" >
            <div class="col-md-4 input" required>
                <label for="FirstName" class="form-label mb-1"><?= $first_name ?></label>
                <input type="text" class="form-control" id="FirstName" between="2,50" name="FirstName" value="<?= $controller->getStorePost("FirstName") ?>" required autocomplete="none">
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_first_name ?>
                </div>
            </div>

            <div class="col-md-4 input" required>
                <label for="LastName" class="form-label mb-1"><?= $last_name  ?></label>
                <input type="text" class="form-control" id="LastName" between="2,50" name="LastName" value="<?= $controller->getStorePost("LastName") ?>" required>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_last_name ?>
                </div>
            </div>


            <div class="col-md-4 input" required>
                <label for="Email" class="form-label mb-1"><?= $email ?></label>
                <input type="email" class="form-control" id="Email" name="Email" email-input value="<?= $controller->getStorePost("Email") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-md-4 input" required>
                <label for="Password" class="form-label mb-1"><?= $password ?></label>
                <input type="password" class="form-control" id="Password" name="Password" value="<?= $controller->getStorePost("Password") ?>"  required>

                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>

                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>

            <div class="col-md-4 input" required>
                <label for="ConfirmPassword" class="form-label mb-1"><?= $confirm_password ?></label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword"  value="<?= $controller->getStorePost("ConfirmPassword") ?>" required>
                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-md-4 input" required>
                <label for="NumberHoursSuccess" class="form-label mb-1"><?= $to_pass_hours ?></label>
                <input type="number"
                       class="form-control"
                       id="NumberHoursSuccess"
                       name="NumberHoursSuccess"
                       between="0, 165"
                       value="<?= $controller->getStorePost("NumberHoursSuccess") ?>" required>

                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>



            <div class="col-md-4 input" required>
                <label for="MajorID" class="form-label mb-1"><?= $major_name ?></label>
                <select class="form-select" id="StudentMajor" name="MajorID" required>
                    <option value=""></option>
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


            <div class="col-md-4 input" required>
                <label for="Gender" class="form-label mb-1"><?= $gender ?></label>
                <select class="form-select" id="Gender" name="Gender" required>
                    <option value="<?= $controller->getStorePost("Gender") ?>"><?= $controller->getStorePost("Gender") ?></option>
                    <option value="Male"><?= $male ?></option>
                    <option value="Female"><?= $female ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-12">
                <button class="main-btn" name="add" type="submit"><?= $add_student ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@