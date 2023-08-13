@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-user-shield"></i>
        <span class="">
            <?= $text_guides ?>
        </span>
    </h1>


    @extend('layout.messages')@

    <!-- Start Table -->
    <div class="container">
        <div class="row mb-20">
            <form action="" class="col-lg-6 col-md-4" METHOD="POST">
                <div class="input-group flex-nowrap">
                    <button class="input-group-text hover" name="search" type="submit" id="addon-wrapping"><i class="fa fa-filter mr-15 main-color"></i> <?= $search  ?></button>
                    <button class="input-group-text hover" name="resit" type="submit" id="addon-wrapping"><i class="fa fa-arrow-rotate-back mr-15 main-color"></i> <?= $resit ?></button>
                    <input type="text" class="form-control" name="value_search" placeholder="<?= $search_guide  ?>" aria-label="Username" aria-describedby="addon-wrapping">
                </div>
            </form>

            <div class="action col-lg-6 col-md-4 d-flex">
                <a href="/guides/add" class="ml-auto">
                    <button class="btn main-btn"> <i class="fa fa-plus main-color mr-5"></i> <?= $add_guide  ?></button>
                </a>
            </div>
        </div>



        <?php
        if ($guides) {
            ?>
            <div class="container-table responsive-table">
                <table class="table pagination-table upper">
                    <thead class="table-dark">
                    <tr>
                        <td><?= $id  ?></td>
                        <td><?= $name_guide ?></td>
                        <td><?= $email ?></td>
                        <td><?= $department_name ?></td>
                        <td><?= $phone_number ?></td>
                        <td><?= $office_hours ?></td>
                        <td><?= $years_of_experience ?></td>
                        <td><?= $controls  ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($guides as $guide) {
                            ?>
                            <tr>
                                <td><?= $guide->GuideID ?></td>
                                <td><?= $guide->GuideName ?></td>
                                <td><?= $guide->Email ?></td>
                                <td><?= $guide->DepartmentName ?></td>
                                <td><?= $guide->PhoneNumber ?></td>
                                <td><?= $guide->OfficeHours ?></td>
                                <td><?= $guide->YearsOfExperience ?></td>
                                <td class="exclude-hover">
                                    <a href="/guides/edit/<?= $guide->GuideID ?>">
                                        <button type="button" class="btn btn-success description" description="<?= $edit ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>

                                    <button type="button" class="btn btn-danger description" btn-popup description="<?= $delete ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- start popup -->
                                    <div class="popup confirm">
                                        <div class="content">
                                            <div class="header">
                                                <div class="icon color-danger bg-danger"><i class="fa fa-exclamation"></i></div>
                                                <h4 class="title">
                                                    <?= $are_you_sure_delete ?>
                                                    <span class="highlight"><?= $guide->GuideName ?></span>
                                                </h4>

                                                <button class="close-btn" close><i class="fa-solid fa-x"></i></button>
                                            </div>

                                            <div class="confirm">
                                                <div class="row g-3 align-items-center">
                                                    <div class="col-12 input-container">
                                                        <label for="confirmText" class="col-form-label no-select">
                                                            <?= $to_confirm ?> <span class="fw-bold" get-used-to><?= $guide->GuideName ?></span>
                                                            <?= $this_box ?>
                                                        </label>
                                                        <input type="text" id="confirmText" class="form-control">
                                                        <div class="buttons mt-10">
                                                            <button class="btn border-1 btn-light cansel" close> <?= $cansel ?> </button>
                                                            <a href="/guides/delete/<?= $guide->GuideID ?>" >
                                                                <button class="btn btn-danger" apply> <?= $apply  ?> </button>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- End popup -->
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        else {
            ?> <div class="alert alert-danger p-1"><?= $no_guides ?></div> <?php
        }
        ?>


    </div>
    <!-- End Table -->

</main>

@extend('layout.footer')@