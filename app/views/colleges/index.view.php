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
                    foreach ($colleges as $collage) {
                        ?>
                        <tr>
                            <td><?= $collage->CollegeID ?></td>
                            <td><?= $collage->CollegeName ?></td>
                            <td><?= $collage->TotalStudents ?></td>
                            <td>

                                <a href="/colleges/edit/<?= $collage->CollegeID ?>">
                                    <button type="button" class="btn btn-success description" description="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-danger description" description="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php

                    }
                    ?>


                    </tbody>
                </table>
            </div>

        </div>
    <!-- End Table -->

</main>

@extend('layout.footer')@