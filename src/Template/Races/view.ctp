<?php
/***
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Race $race
 */
?>

<h2>Details of Race #<?= $race->id ?></h2>

<div class="row mt-2">
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
            </div>

        </div>

    <?php if( !$race->isFinished() ): ?>
        <div class="w-100"></div>
        <div class="col text-center mt-2">
            <?= $this->Html->link('Progress', ['controller'=>'Races','action'=>'Progress'],
                ['class'=>'btn btn-lg btn-success']) ?>
        </div>
    <?php endif; ?>
</div>

<div class="row justify-content-center mt-5">
    <h3>Horses</h3>
    <div class="w-100"></div>
    <div class="col-md-10">
        <canvas class="chart-race" id="chart-horses-<?= $race->id ?>" width="100" height="300"></canvas>
    </div>
</div>

<div class="mt-5">&nbsp;</div>


<script>

    $('.chart-race').each(function(index,el) {
        var width = $(el).parent()[0].offsetWidth;
        var padding = parseInt($(el).parent().css('padding-right').match(/\d+/)[0])*2;
        $(el).attr('width', width-padding);
    });


    <?php  $horses = new \Cake\Collection\Collection($race->horse_races);
        $horseNames = $horses->extract('horse.name')->toList();
        $distances = $horses->extract('distance')->toList();
        $strengthList = $horses->extract('horse.strength')->toList();
        $enduranceList = $horses->extract('horse.endurance')->toList();
        $speedList = $horses->extract('horse.speed')->toList();
    ?>
    populateSingleRaceChart(<?=$race->id?>,<?= json_encode($horseNames) ?>, <?= json_encode($distances) ?>);

    populateRaceHorsesChart(<?=$race->id?>,<?= json_encode($horseNames) ?>, [<?= json_encode($speedList)?>,<?=
        json_encode($enduranceList) ?>, <?= json_encode($strengthList) ?>]);

</script>