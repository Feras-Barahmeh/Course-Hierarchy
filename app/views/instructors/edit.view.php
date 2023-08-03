@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">

    <h1 class="main-title">
        <i class="fa-solid fa-edit"></i>

        <span class="">
            <?= $edit .' '. ucfirst($instructor->FirstName) . ' ' . ucfirst($instructor->LastName) ?> <?= $text_instructor ?>
        </span>
    </h1>

    <div class="container mt-20">
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
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/instructors/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i> <?= $to_instructor ?></button>
                </a>
            </div>
        </div>

        <div class="container-form">
            <form class="row g-3" method="POST" >
                <div class="col-md-6">
                    <label for="PhoneNumber" class="form-label mb-1"><?= $phone_number ?></label>
                    <input type="text"
                           class="form-control"
                           id="PhoneNumber"
                           between="10,10"
                           name="PhoneNumber"
                           value="<?=$instructor->PhoneNumber ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="City" class="form-label mb-1"><?= $city ?></label>
                    <input type="text"
                           class="form-control"
                           id="City"
                           between="2,50"
                           name="City"
                           value="<?=$instructor->City ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="State" class="form-label mb-1"><?= $state ?></label>
                    <input type="text"
                           class="form-control"
                           id="State"
                           between="2,50"
                           name="State"
                           value="<?=$instructor->State ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>


                <div class="col-md-6">
                    <label for="Country" class="form-label mb-1"><?= $country ?></label>
                    <input type="text"
                           class="form-control"
                           id="Country"
                           between="2,50"
                           name="Country"
                           value="<?=$instructor->Country ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="DOB" class="form-label mb-1"><?= $DOB ?></label>
                    <input type="date"
                           class="form-control"
                           id="DOB"
                           name="DOB"
                           value="<?=$instructor->DOB ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>


                <div class="col-md-6">
                    <label for="HireDate" class="form-label mb-1"><?= $hire_date ?></label>
                    <input type="date"
                           class="form-control"
                           id="HireDate"
                           name="HireDate"
                           value="<?=$instructor->HireDate ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>


                <div class="col-md-6">
                    <label for="YearsOfExperience" class="form-label mb-1"><?= $years_of_experience ?></label>
                    <input type="text"
                           class="form-control"
                           id="YearsOfExperience"
                           between="0, 50"
                           name="YearsOfExperience"
                           value="<?=$instructor->YearsOfExperience ?>"
                           autocomplete="none"
                    >

                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>


                <div class="col-md-6">
                    <label for="Address" class="form-label mb-1"><?= $address ?></label>
                    <input type="number"
                           class="form-control"
                           id="Address"
                           between="2, 100"
                           name="Address"
                           value="<?= $instructor->Address ?>"

                    >
                    <div class="valid-feedback">
                        <?= $valid_feedback ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= $invalid_feedback ?>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn main-btn" name="edit" type="submit"> <?= $edit_info ?></button>
                </div>
            </form>
        </div>

    </div>
</main>

@extend('layout.footer')@