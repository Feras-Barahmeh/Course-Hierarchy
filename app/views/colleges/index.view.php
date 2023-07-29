@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-building"></i>
        <span class="">
            Colleges
        </span>
    </h1>

    <div class="container">
        <?php
        $messages = \App\Core\Session::flash("message");

        if ($messages) {
            foreach ($messages as $message) {
                $type = strtolower($message[1]->name);
                $message = $message[0];
                ?>
                <div class="alert alert-<?= $type ?> between-element plr-20 " kick-out="5000" role="alert">
                    <span class="flex f-align-center"><?= $message ?></span>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Start Table -->
        <div class="container container-table responsive-table">
            <div class="row mb-20">
                <form action="" class="col-lg-6 col-md-4" METHOD="POST">
                    <div class="input-group flex-nowrap">
                        <button class="input-group-text hover" name="search" type="submit" id="addon-wrapping"><i class="fa fa-filter mr-15 main-color"></i> Search</button>
                        <button class="input-group-text hover" name="resit" type="submit" id="addon-wrapping"><i class="fa fa-arrow-rotate-back mr-15 main-color"></i> Resit</button>
                        <input type="text" class="form-control" name="value_search" placeholder="Search Collage" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                </form>

                <div class="action col-lg-6 col-md-4 d-flex">
                    <a href="/colleges/add" class="ml-auto">
                        <button class="btn main-btn"> <i class="fa fa-plus main-color mr-5"></i> Add College</button>
                    </a>
                </div>
            </div>



            <div class="container-table responsive-table">
                <table class="table pagination-table">
                    <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Name Collage</td>
                        <td>Count Student</td>
                        <td>Controls</td>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                        if ($colleges) {
                            foreach ($colleges as $collage) {
                                ?>
                                <tr>
                                    <td><?= $collage->CollegeID ?></td>
                                    <td><?= $collage->CollegeName ?></td>
                                    <td><?= $collage->TotalStudents ?></td>
                                    <td class="exclude-hover">
                                        <a href="/colleges/edit/<?= $collage->CollegeID ?>">
                                            <button type="button" class="btn btn-success description" description="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>

                                        <button type="button" class="btn btn-danger description" btn-popup description="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- start popup -->
                                        <div class="popup confirm">
                                            <div class="content">
                                                <div class="header">
                                                    <div class="icon color-danger bg-danger"><i class="fa fa-exclamation"></i></div>
                                                    <h4 class="title">
                                                        Are You Sure you want delete
                                                        <span class="highlight"><?= $collage->CollegeName ?></span>
                                                    </h4>

                                                    <button class="close-btn" close><i class="fa-solid fa-x"></i></button>
                                                </div>

                                                <div class="confirm">
                                                    <div class="row g-3 align-items-center">
                                                        <div class="col-12 input-container">
                                                            <label for="confirmText" class="col-form-label no-select">
                                                                To confirm, type <span class="fw-bold" get-used-to><?= $collage->CollegeName ?></span>
                                                                in this box below
                                                            </label>
                                                            <input type="text" id="confirmText" class="form-control">
                                                            <div class="buttons mt-10">
                                                                <button class="btn border-1 btn-light cansel" close> Cansel </button>
                                                                <a href="/colleges/delete/<?= $collage->CollegeID ?>" >
                                                                    <button class="btn btn-danger" apply> Apply </button>
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
                        } else {
                            ?> <div class="alert alert-danger p-1">No Colleges</div> <?php
                        }
                    ?>


                    </tbody>
                </table>
            </div>

        </div>
    <!-- End Table -->

</main>

@extend('layout.footer')@