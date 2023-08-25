@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideGuider')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-square-poll-vertical"></i>
        <span class="">
            <?= $text_votes  ?>
        </span>
    </h1>

    @extend('layout.messages')@

    <div class="container">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/guider/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_dashboard  ?></button>
                </a>
            </div>
        </div>
    </div>

    <div class="g-3 wrapper votes d-grid gap-20">
        <?php
            foreach ($votesGuider as $vote ) {

                ?>
                    <div class="task-row vote rad-6 relative bg-secondary p-10 <?= $vote->TimeExpired <= date("Y-m-d H:i:s") ? 'finish' : '' ?>" expired="<?= $te ?>">
                        <h3 class="fs-4 txt-c vote-title"><?= $vote->Title ?></h3>
                        <div class="flex between-element p-1">
                            <div class="flex flex-column">
                                <p class="m-0 c-grey"><?= $ts ?> <span class='highlight'> <?= $vote->TimeShare ?> </span> </p>
                                <p class="m-0 c-grey"><?= $te ?> <span class='highlight'> <?= $vote->TimeExpired ?> </span> </p>
                            </div>
                            <div class="flex flex-column gap-10">
                                <a href="/guider/edit/<?= $vote->VoteID ?>" class="main-btn description" description="<?= $edit ?>"><i class="fa fa-edit"></i></a>
                                <button class="main-btn description btn-statistic" id="<?= $vote->VoteID ?>"  description="<?= $statistic ?>"><i class="fa-solid fa-chart-simple"></i></button>
                            </div>
                        </div>


                        <div class="statistics offcanvas offcanvas-start" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasLabel"> <?= $statistic_for ?> <?= $vote->Title ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="g-3 p-20 courses">

                            </div>
                        </div>

                    </div>


                <?php
            }
        ?>
    </div>
</main>

@extend('layout.footer')@