@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-building"></i>
        <span class="">

            <?= $text_departments?>
        </span>
    </h1>

    @extend('layout.messages')@

    <!-- Start Table -->
    <div class="container">
        @extend('layout.SearchBar')@


        <?php
        if ($departments) {
            
            ?>
            <div class="container-table responsive-table">
                <table class="table pagination-table upper">
                    <thead class="table-dark">
                    <tr>
                        <td><?= $id  ?></td>
                        <td><?= $name_department ?></td>
                        <td><?= $college_name ?></td>
                        <td><?= $count_students  ?></td>
                        <td><?= $controls  ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($departments as $department) {
                        ?>
                        <tr>
                            <td><?= $department->DepartmentID ?></td>
                            <td><?= $department->DepartmentName ?></td>
                            <td><?= $department->CollegeName ?></td>
                            <td><?= $department->TotalStudentsInDepartment ?></td>
                            <td class="exclude-hover">
                                <a href="/departments/edit/<?= $department->DepartmentID ?>">
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
                                                <span class="highlight"><?= $department->DepartmentName ?></span>
                                            </h4>

                                            <button class="close-btn" close><i class="fa-solid fa-x"></i></button>
                                        </div>

                                        <div class="confirm">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-12 input-container">
                                                    <label for="confirmText" class="col-form-label no-select">
                                                        <?= $to_confirm ?> <span class="fw-bold" get-used-to><?= $department->DepartmentName ?></span>
                                                        <?= $this_box ?>
                                                    </label>
                                                    <input type="text" id="confirmText" class="form-control">
                                                    <div class="buttons mt-10">
                                                        <button class="btn border-1 btn-light cansel" close> <?= $cansel ?> </button>
                                                        <a href="/departments/delete/<?= $department->DepartmentID ?>" >
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
            ?> <div class="alert alert-info p-2"><?= $no_departments ?></div> <?php
        }
        ?>


    </div>
    <!-- End Table -->

</main>

@extend('layout.footer')@