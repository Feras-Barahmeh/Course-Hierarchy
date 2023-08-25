@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideStudent')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-graduation-cap"></i>
        <span class="name-student">
            <span class=""><?= $user->FirstName . ' ' . $user->LastName ?></span>
        </span>
    </h1>

    @extend('layout.messages')@


    <div class="wrapper d-grid gap-20">
        <!-- Start Welcome Widget -->
        <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
            <div class="intro p-20 d-flex space-between bg-eee">
                <div>
                    <h2 class="m-0"><?= $welcome ?></h2>
                    <p class="c-grey mt-5"><?= $user->FirstName ?></p>
                </div>
                <img class="hide-mobile" src="<?= IMG ?>welcome.png" alt="" />
            </div>
            <img src="<?= IMG ?>avatar.png" alt="" class="avatar" />
            <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                <div><?= $user->FirstName . ' ' . $user->LastName ?> <span class="d-block c-grey fs-14 mt-10"> <?= $user->MajorName ?></span></div>

            </div>
        </div>
        <!-- End Welcome Widget -->
        <!-- Start Tasks Widget -->
        <div class="tasks p-20 bg-white rad-10 position-relative">
            <h2 class="mt-0 mb-20"><?= $last_votes ?></h2>
            <?php
                foreach ($votes as $vote) {

                    ?>
                        <div class="task-row between-flex">
                            <div class="info">
                                <h3 class="mt-0 mb-5 fs-15 position-relative flex align-center gap-10">

                                    <?= ! \App\Helper\Handel::ifBallot($vote->VoteID) ?
                                        '<span class="notification"></span>' :
                                        ' <i class="fa-solid fa-check chased"></i>'
                                    ?>
                                    <?= $vote->Title ?>
                                </h3>
                                <p class="m-0 c-grey"><?= $ts ?> <span class='highlight'> <?= $vote->TimeShare ?> </span> </p>
                                <p class="m-0 c-grey"><?= $te ?> <span class='highlight'> <?= $vote->TimeExpired ?> </span> </p>
                            </div>
                            <a href="/student/ballot/<?= $vote->VoteID ?>"><i class="fa-brands fa-readme pointer mr-5"></i><?= $poll ?></a>
                        </div>
                    <?php
                }
            ?>


        </div>
        <!-- End Tasks -->

        <!-- Start Ticket Widget -->
        <div class="tickets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10"><?= $statistics ?></h2>
            <div class="d-flex txt-c gap-20 f-wrap">
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->Gender ?></span>
                    <?= $gender ?>
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-solid fa-spinner fa-2x mb-10 c-blue"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->PhoneNumber ?? "Not Added Yet" ?></span>
                    <?= $pn ?>
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-circle-check fa-2x mb-10 c-green"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->MajorName ?></span>
                    <?= $major ?>
                </div>

            </div>
        </div>
        <!-- End Ticket Widget -->
    </div>
</main>

@extend('layout.footer')@