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
                    <h2 class="m-0">Welcome</h2>
                    <p class="c-grey mt-5"><?= $user->FirstName ?></p>
                </div>
                <img class="hide-mobile" src="<?= IMG ?>welcome.png" alt="" />
            </div>
            <img src="<?= IMG ?>avatar.png" alt="" class="avatar" />
            <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                <div><?= $user->FirstName  ?> <span class="d-block c-grey fs-14 mt-10"> <?= $user->MajorName ?> Student</span></div>

            </div>
        </div>
        <!-- End Welcome Widget -->
        <!-- Start Tasks Widget -->
        <div class="tasks p-20 bg-white rad-10">
            <h2 class="mt-0 mb-20">Latest vote</h2>
            <div class="task-row between-flex">
                <div class="info">
                    <h3 class="mt-0 mb-5 fs-15">Record One New Video</h3>
                    <p class="m-0 c-grey">Record Python Create Exe Project</p>
                </div>
<!--                <i class="fa-regular fa-trash-can delete"></i>-->
            </div>


        </div>
        <!-- End Tasks -->

        <!-- Start Ticket Widget -->
        <div class="tickets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Statistics</h2>
            <p class="mt-0 mb-20 c-grey fs-15">Everything About</p>
            <div class="d-flex txt-c gap-20 f-wrap">
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->Gender ?></span>
                    Gender
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-solid fa-spinner fa-2x mb-10 c-blue"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->PhoneNumber ?? "Not Added Yet" ?></span>
                    Phone Number
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-circle-check fa-2x mb-10 c-green"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->MajorName ?></span>
                    Major
                </div>

            </div>
        </div>
        <!-- End Ticket Widget -->
    </div>
</main>

@extend('layout.footer')@