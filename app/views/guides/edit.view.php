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
                <a href="/guides/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_guides  ?></button>
                </a>
            </div>
        </div>
    </div>
    @extend('layout.messages')@
    <div class="container mt-20 container-form">


        <form class="row g-3" method="POST">
            <div class="col-md-4 input" required>
                <label for="GuideName" class="form-label mb-1"><?= $name_guide ?></label>
                <input type="text" class="form-control" id="GuideName" between="2,50" name="GuideName" value="<?= $controller->getStorePost("GuideName", $guide) ?>" required autocomplete="none">
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
                <div class="invalid-feedback">
                    <?= $invalid_feedback_first_name ?>
                </div>
            </div>



            <div class="col-md-4 input" required>
                <label for="GuideDepartmentID" class="form-label mb-1"><?= $department_name ?></label>
                <select class="form-select" id="GuideDepartmentID" name="GuideDepartmentID" required>

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



            <div class="col-md-4 ">
                <label for="PhoneNumber" class="form-label mb-1"><?= $phone_number ?></label>
                <input type="number"
                       class="form-control"
                       id="PhoneNumber"
                       name="PhoneNumber"
                       between="0, 10"
                       value="<?= $controller->getStorePost("PhoneNumber", $guide) ?>" >

                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-md-4 ">
                <label for="YearsOfExperience" class="form-label mb-1"><?= $years_of_experience ?></label>
                <input type="number"
                       class="form-control"
                       id="YearsOfExperience"
                       name="YearsOfExperience"
                       value="<?= $controller->getStorePost("YearsOfExperience", $guide) ?>" >

                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>

            <div class="col-md-4">
                <label for="OfficeHours" class="form-label mb-1"><?= $office_hours ?></label>
                <input type="text"
                       class="form-control"
                       id="OfficeHours"
                       name="OfficeHours"
                       value="<?= $controller->getStorePost("OfficeHours", $guide) ?>" >

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