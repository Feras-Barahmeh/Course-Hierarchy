@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-graduation-cap"></i>
        <span class="">

            <?= $text_majors?>
        </span>
    </h1>

    @extend('layout.messages')@

    <!-- Start Table -->
    <div class="container">
        @extend('layout.SearchBar')@

        <?php
        if ($majors) {

            ?>
            <div class="container-table responsive-table">
                <table class="table pagination-table upper">
                    <thead class="table-dark">
                    <tr>
                        <td><?= $id  ?></td>
                        <td><?= $name_major ?></td>
                        <td><?= $number_hours_major ?></td>
                        <td><?= $number_student_major ?></td>
                        <td><?= $courses_number ?></td>
                        <td><?= $department ?></td>
                        <td><?= $college  ?></td>
                        <td><?= $controls  ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($majors as $major) {
                        ?>
                        <tr>
                            <td><?= $major->MajorID ?></td>
                            <td><?= $major->MajorName ?></td>
                            <td><?= $major->NumberHoursMajor ?></td>
                            <td><?= $major->NumberStudentInMajor ?></td>
                            <td><?= $major->CoursesNumber ?></td>
                            <td><?= $major->DepartmentName ?></td>
                            <td><?= $major->CollegeName ?></td>
                            <td class="exclude-hover">
                                <a href="/majors/edit/<?= $major->MajorID ?>">
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
                                                <span class="highlight"><?= $major->MajorName ?></span>
                                            </h4>

                                            <button class="close-btn" close><i class="fa-solid fa-x"></i></button>
                                        </div>

                                        <div class="confirm">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-12 input-container">
                                                    <label for="confirmText" class="col-form-label no-select">
                                                        <?= $to_confirm ?> <span class="fw-bold" get-used-to><?= $major->MajorName ?></span>
                                                        <?= $this_box ?>
                                                    </label>
                                                    <input type="text" id="confirmText" class="form-control">
                                                    <div class="buttons mt-10">
                                                        <button class="btn border-1 btn-light cansel" close> <?= $cansel ?> </button>
                                                        <a href="/majors/delete/<?= $major->MajorID ?>" >
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
            ?> <div class="alert alert-info p-2"><?= $no_major ?></div> <?php
        }
        ?>


    </div>
    <!-- End Table -->

</main>

@extend('layout.footer')@