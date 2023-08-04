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
                <a href="/instructors/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_instructor  ?></button>
                </a>
            </div>
        </div>
    </div>
    <div class="container mt-20 container-form">

        <?php
            if ($messages) {
                foreach ($messages as $message) {

                    $type = is_object($message[1]) ? strtolower($message[1]->name) : strtolower($message[1]);
                    $message = $message[0];
                    ?>
                    <div class="alert alert-<?= $type ?> between-element  plr-10 ptb-5 " kick-out="5000" role="alert">
                        <span class="flex f-align-center"><?= $message ?></span>
                    </div>
                    <?php
                }
            }
        ?>
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
                <label for="NationalIdentificationNumber" class="form-label mb-1"><?= $national_id_num ?></label>
                <input type="text" class="form-control" id="NationalIdentificationNumber" name="NationalIdentificationNumber"  between="11, 11" value="<?= $controller->getStorePost("NationalIdentificationNumber") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_national_id_num ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>

            <div class="col-md-4 input" required>
                <label for="Department" class="form-label mb-1"><?= $department ?></label>
                <select class="form-select" id="Department" name="Department" required>

                    <?php
                        foreach ($departments as $department) {
                            ?>
                                <option value="<?= $department->DepartmentID ?>"><?= $department->DepartmentName ?></option>
                            <?php
                        }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-md-2 input" required>
                <label for="Salary" class="form-label mb-1"><?= $salary ?></label>
                <input type="number" class="form-control" id="Salary" name="Salary" value="<?= $controller->getStorePost("Salary") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-md-2 input" required>
                <label for="YearsOfExperience" class="form-label mb-1"><?= $years_of_experience ?></label>
                <input type="number" class="form-control" id="YearsOfExperience" name="YearsOfExperience" min="0" value="<?= $controller->getStorePost("YearsOfExperience") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-md-2 input" required>
                <label for="IfFullTime" class="form-label mb-1"><?= $is_full_time ?></label>
                <select class="form-select" id="IfFullTime" name="IfFullTime" required>
                    <option selected disabled value="<?= $controller->getStorePost("IfFullTime") ?>">
                        <?= $controller->getStorePost("IfFullTime") ? $yes :$choose ?>
                    </option>
                    <option value="1"><?= $yes ?></option>
                    <option value="0"><?= $no ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>

            <div class="col-md-2 input" required>
                <label for="IsActive" class="form-label mb-1"><?= $is_active ?></label>
                <select class="form-select" id="IsActive" name="IsActive" required>
                    <option selected disabled value="<?= $controller->getStorePost("IsActive") ?>">
                        <?= $controller->getStorePost("IsActive") ?  $yes :$choose ?>
                    </option>
                    <option value="1"><?= $yes ?></option>
                    <option value="0"><?= $no ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-12">
                <button class="main-btn" name="add" type="submit"><?= $add_instructor ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@