@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-building"></i>
        <span class="">
            Collages
        </span>
    </h1>
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

    <!-- Start Table -->
        <div class="container container-table responsive-table">
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
                    foreach ($collages as $collage) {
                        ?>
                            <tr>
                                <td><?= $collage->CollageID ?></td>
                                <td><?= $collage->CollegeName ?></td>
                                <td><?= $collage->TotalStudents ?></td>
                                <td>

                                    <button type="button" class="btn btn-success">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger">
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
    <!-- End Table -->

</main>

@extend('layout.footer')@