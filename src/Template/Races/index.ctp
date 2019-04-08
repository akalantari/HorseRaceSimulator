<?php
/***
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Race[] $races
 * @var \App\Model\Entity\Race[] $finishedRaces
 * @var \App\Model\Entity\HorseRace $bestTime
 */
?>

<div class="row mt-3">
    <div class="col-12 text-center">
        <?= $this->Form->create(null,['url'=>['controller'=>'Races','action'=>'create']]); ?>
        <button class="btn btn-primary btn-lg">Create Race</button>
        <?= $this->Form->end(); ?>
    </div>
</div>

<div class="row mt-4">
    <?php if( !$races->isEmpty() ): ?>
        <?php foreach($races as $race): ?>
            <div class="col-12 col-md">
                <canvas class="chart-race" id="chart-race-<?= $race->id ?>" width="100" height="300"></canvas>

                <div class="row justify-content-md-center mt-5">
                    <div class="col-9 text-center ">
                        <table class="table">
                            <tbody>
                            <?php foreach($race->horse_races as $k=>$horse_race): ?>
                                <tr>
                                    <td>
                                        <span class="badge"><?= \Cake\I18n\Number::ordinal($k+1) ?>.</span> <?= $horse_race->horse->name ?>
                                        <br />
                                        <?php if( $horse_race->isFinished() ): ?>
                                            <span class="badge">Time: <?= \App\Lib\HorseRaceSimulatorLib::secondsToTime($horse_race->running_time) ?></span>
                                        <?php else: ?>
                                            <span class="badge">Distance: <?= $horse_race->distance ?>m</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center">
                    <div class="">
                        <span class="badge badge-pill">
                            Run Time: <?= \App\Lib\HorseRaceSimulatorLib::secondsToTime($race->running_time) ?>
                        </span>
                    </div>
                    <?= $this->Html->link('Race details for Race #'.$race->id, ['controller'=>'Races','action'=>'view', $race->id]) ?>
                </div>

            </div>
        <?php endforeach; ?>
        <div class="w-100"></div>
        <div class="col text-center mt-2">
            <?= $this->Html->link('Progress', ['controller'=>'Races','action'=>'Progress'],
                ['class'=>'btn btn-lg btn-success']) ?>
        </div>
    <?php else: ?>
        <div class="col-12 text-center">
            No Races Are Running Currently
        </div>
    <?php endif; ?>
</div>

<hr class="mt-5" />

<div class="row text-center justify-content-center">
    <div class="col-md-10">
        <h4>Best Run Time Ever</h4>
        <?php if( $bestTime ): ?>
            <h1><?= $bestTime->horse->name ?></h1>
            finished race #<?= $bestTime->race->id ?> in
            <h3><?= \App\Lib\HorseRaceSimulatorLib::secondsToTime($bestTime->running_time) ?></h3>
            <?= $this->Html->link('View Race Details',['controller'=>'Races','action'=>'view', $bestTime->race->id],
                ['class'=>'btn btn-info']) ?>

            <div class="w-100"></div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <canvas class="chart-race" id="chart-horse-<?= $bestTime->horse->id ?>" width="100" height="300"></canvas>
                </div>
            </div>
        <?php else: ?>
            No race has been finished yet
        <?php endif; ?>
    </div>
</div>

<hr class="mt-5" />

<div class="row justify-content-md-center mt-5">
    <div class="col-12 col-md-6 text-center">
        <h3>Results of The Last 5 Races</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">1st Place</th>
                <th scope="col">2nd Place</th>
                <th scope="col">3rd Place</th>
                <th scope="col">Run Time</th>
                <th scope="col"></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach( $finishedRaces as $race ): ?>
                <tr>
                    <th scope="row"><?= $race->id ?></th>
                    <?php for($i=0; $i<3; $i++): ?>
                        <td>
                            <?= $race->horse_races[$i]->horse->name ?>
                            <br />
                            <span class="badge">Time: <?= \App\Lib\HorseRaceSimulatorLib::secondsToTime($race->horse_races[$i]->running_time) ?></span>
                        </td>
                    <?php endfor; ?>
                    <td>
                        <?= \App\Lib\HorseRaceSimulatorLib::secondsToTime($race->running_time); ?>
                    </td>
                    <td>
                        <?= $this->Html->link('Details', ['controller'=>'Races','action'=>'view',$race->id],
                            ['class'=>'btn btn-sm btn-info']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>

<script>

    $('.chart-race').each(function(index,el) {
        var width = $(el).parent()[0].offsetWidth;
        var padding = parseInt($(el).parent().css('padding-right').match(/\d+/)[0])*2;
        $(el).attr('width', width-padding);
    });


    <?php foreach($races as $race):
        $horses = new \Cake\Collection\Collection($race->horse_races);
        $horseNames = $horses->extract('horse.name')->toList();
        $distances = $horses->extract('distance')->toList();
        ?>
        populateSingleRaceChart(<?=$race->id?>,<?= json_encode($horseNames) ?>, <?= json_encode($distances) ?>);
    <?php
        endforeach;
    ?>

    <?php if( $bestTime ): ?>
        var bestTimeHoreseStats = [<?=$bestTime->horse->speed?>,<?=$bestTime->horse->endurance?>,<?=$bestTime->horse->strength?>];
        populateSingleHorseChart(<?=$bestTime->horse->id?>,'<?=$bestTime->horse->name?>',bestTimeHoreseStats);
    <?php endif; ?>

</script>