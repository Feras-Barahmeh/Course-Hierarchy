@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideGuider')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-compass"></i>
        <span class="name-student">
            <span class=""><?= $user->GuideName  ?></span>
        </span>
    </h1>

    @extend('layout.messages')@
    <div class="content w-full">

        <div class="wrapper d-grid gap-20">
            <!-- Start Welcome Widget -->
            <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
                <div class="intro p-20 d-flex space-between bg-eee">
                    <div>
                        <h2 class="m-0">Welcome</h2>
                        <p class="c-grey mt-5"><?= $user->GuideName ?></p>
                    </div>
                    <img class="hide-mobile" src="<?= IMG ?>welcome.png" alt="" />
                </div>
                <img src="<?= IMG ?>avatar.png" alt="" class="avatar" />
                <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                    <div><?= $user->GuideName  ?> <span class="d-block c-grey fs-14 mt-10">Guider</span></div>

                </div>
            </div>
            <!-- End Welcome Widget -->
            <!-- Start Tasks Widget -->
            <div class="tasks p-20 bg-white rad-10">
                <div class="mt-0 mb-20 task-header between-element ">
                    <h2 class="">Latest vote</h2>
                    <a href="/guider/vote" class="main-btn"><i class="fa fa-plus"></i>Add</a>
                </div>
                <?php

                    if ($votes) {
                        foreach ($votes as $vote ) {
                            ?>
                            <div class="task-row between-flex <?= $vote->IsActive ? '' : 'done'  ?>">
                                <div class="info">
                                    <h3 class="mt-0 mb-5 fs-15"><?= $vote->Title ?></h3>
                                    <p class="m-0 c-grey">
                                        <?= $vote->ForYear ? $vote->ForYear . ' | ' : '' ?>
                                        <?= $vote->MajorName ? $vote->MajorName . ' | ' : '' ?>
                                        <?= $vote->DepartmentName ?? '' ?>
                                    </p>
                                </div>
                                <div class="options flex flex-column gap-2">

                                    <button class="vote-btn description  <?= $vote->IsActive ? 'is-active' : 'is-not-active'  ?>" description="convert status">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <a href="/guider/delete/<?= $vote->VoteID ?>"><i class="fa-regular fa-trash-can delete"></i></a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?> <div class="alert alert-info p-2"><?= $no_votes ?></div> <?php
                    }
                ?>
<!--                <div class="task-row between-flex">-->
<!--                    <div class="info">-->
<!--                        <h3 class="mt-0 mb-5 fs-15">Record One New Video</h3>-->
<!--                        <p class="m-0 c-grey">Record Python Create Exe Project</p>-->
<!--                    </div>-->
<!--                    <i class="fa-regular fa-trash-can delete"></i>-->
<!--                </div>-->
<!---->
<!--                <div class="task-row between-flex done">-->
<!--                    <div class="info">-->
<!--                        <h3 class="mt-0 mb-5 fs-15">Attend The Meeting</h3>-->
<!--                        <p class="m-0 c-grey">Attend The Project Business Analysis Meeting</p>-->
<!--                    </div>-->
<!--                    <i class="fa-regular fa-trash-can delete"></i>-->
<!--                </div>-->

            </div>
            <!-- End Tasks -->

            <!-- Start Ticket Widget -->
            <div class="tickets p-20 bg-white rad-10">
                <h2 class="mt-0 mb-10">Information</h2>
                <p class="mt-0 mb-20 c-grey fs-15">Everything About</p>
                <div class="d-flex txt-c gap-20 f-wrap">
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5"><?= $user->OfficeHours ?></span>
                        Office Hours
                    </div>

            </div>
            <!-- End Ticket Widget -->
    </div>
</main>
@extend('layout.footer')@