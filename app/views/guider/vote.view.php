@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideGuider')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-square-poll-vertical"></i>
        <span class="">
            <?= $text_vote  ?>
        </span>
    </h1>

    @extend('layout.messages')@

    <div class="container">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/guider/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_dashboard  ?></button>
                </a>
            </div>
        </div>

    </div>
    <div class="container mt-20 container-form">


        <form class="row g-3" method="POST" >
            <div class="col-md-6 input" required>
                <label for="Title" class="form-label mb-1">Title Vote</label>
                <input type="text" class="form-control" id="Title" name="Title"  value="<?= $controller->getStorePost("Title") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="ForYear" class="form-label mb-1"><?= $text_years ?></label>
                <select class="form-select" id="ForYear" name="ForYear">
                    <option value=""></option>

                    <?php
                        foreach ($years as $value => $year) {
                            ?>
                                <option <?= $controller::setSelectedAttribute($value, $controller->getStorePost("ForYear") ) ?>
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




            <div class="col-md-6">
                <label for="ForMajor" class="form-label mb-1"><?= $text_majors ?></label>
                <select class="form-select" id="ForMajor" name="ForMajor">
                    <option value=""></option>

                    <?php
                    foreach ($majors as $major) {

                        ?>
                        <option <?= $controller::setSelectedAttribute($major->MajorID, $controller->getStorePost("ForMajor") ) ?>
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


            <div class="col-md-6 input" required>
                <label for="TimeExpired" class="form-label mb-1">TimeExpired Vote</label>
                <input type="datetime-local" class="form-control" id="TimeExpired" name="TimeExpired"  value="<?= $controller->getStorePost("TimeExpired") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-12">
                <button class="main-btn" name="share" type="submit"><?= $share_vote ?></button>
            </div>
        </form>
<!---->
<!--        <div class="alert alert-primary mt-3" >-->
<!--            if choose year student the target student all student(in your department)-->
<!--            if chosse-->
<!--        </div>-->
    </div>

</main>

@extend('layout.footer')@