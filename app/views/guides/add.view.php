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
                <a href="/guides/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_guides  ?></button>
                </a>
            </div>
        </div>
    </div>
    @extend('layout.messages')@
    <div class="container mt-20 container-form">


        <form class="row g-3" method="POST" >
            <div class="col-md-4 input" required>
                <label for="GuideName" class="form-label mb-1"><?= $name_guide ?></label>
                <input type="text" class="form-control" id="GuideName" between="3,100" name="GuideName" value="<?= $controller->getStorePost("GuideName") ?>" required autocomplete="none">
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $name_guide_invalid_feedback ?>
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
                <label for="GuideDepartmentID" class="form-label mb-1"><?= $department_name ?></label>
                <select class="form-select" id="GuideDepartmentID" name="GuideDepartmentID" required>
                    <option value=""></option>
                    <?php
                    foreach ($departments as $department) {

                        ?>
                        <option
                            <?= $controller->setSelectedAttribute( $controller->getStorePost("GuideDepartmentID"), $department->DepartmentID ) ?>
                                value="<?= $department->DepartmentID ?>"
                        >
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


            <div class="col-12">
                <button class="main-btn" name="add" type="submit"><?= $add_guide ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@