<?php
use App\Services\Translator\Translator;
use \App\Repository\Users\UserRepository;
use App\Repository\AnalyticsRepository;
use \App\Repository\Review\ReviewRepository;
use \App\Repository\ReservationRepository;
use \App\Core\Framework;
use \App\Services\Front\Front;
?>

<section class="content">

    <h1><?= Translator::trans('admin_homepage_title'); ?></h1>

    <?php $this->include('error.tpl') ?>

    <div class="container container-row">
        <!------- CARD STATS ---------->
        <div class="col-3">
            <div class="card" style="border: transparent">
                <div class="card-body card-stats">
                    <span><?= Translator::trans('admin_home_card_user_registered'); ?></span><br>
                    <span style="color: #000000"><?= UserRepository::getUserNumber() ?? '0'; ?> <i class="fas fa-user"></i></span>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card" style="border: transparent">
                <div class="card-body card-stats">
                    <span><?= Translator::trans('admin_home_card_visitor_today'); ?></span><br>
                    <span style="color: #000000"><?= AnalyticsRepository::getTodayVisit() ?? '0'; ?> <?php if(AnalyticsRepository::getPreviousDayVisit() < AnalyticsRepository::getTodayVisit()) {echo '<i style="color: green" class="fas fa-arrow-up fa-rotate-45"></i>';} elseif(AnalyticsRepository::getPreviousDayVisit() < AnalyticsRepository::getTodayVisit()) {echo '<i style="color: red" class="fas fa-arrow-down fa-rotate--45"></i>';} else {echo '<i class="fas fa-equals"></i>';} ?></span>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card" style="border: transparent">
                <div class="card-body card-stats">
                    <span><?= Translator::trans('admin_home_card_reservation_today'); ?></span><br>
                    <span style="color: #000000"><?= ReservationRepository::getReservationToday() ?? '0'; ?> <i class="fas fa-user"></i></span>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card" style="border: transparent">
                <div class="card-body card-stats">
                    <span><?= Translator::trans('admin_home_card_comment'); ?></span><br>
                    <span style="color: #000000"><?= ReviewRepository::getTodayVisit() ?? '0'; ?></span>
                </div>
            </div>
        </div>
        <!------- CARD STATS ---------->
    </div>


    <div class="container">
        <!------- CARD STATS VISIT ---------->
        <div class="col-12">
            <div class="card" style="border: transparent">
                <div class="card-body">
                    <canvas id="myChart" width="100%" height="35px"></canvas>
                </div>
            </div>
        </div>
        <!------- CARD STATS VISIT ---------->
    </div>
</section>

<script src="<?php Framework::getResourcesPath('chartjs.js') ?>" type="text/javascript"></script>
<script>
    <?php $chart_data = AnalyticsRepository::getWeekVisit(); ?>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                '<?= Front::date('now', 'd/m', '-6 day'); ?>',
                '<?= Front::date('now', 'd/m', '-5 day'); ?>',
                '<?= Front::date('now', 'd/m', '-4 day'); ?>',
                '<?= Front::date('now', 'd/m', '-3 day'); ?>',
                '<?= Front::date('now', 'd/m', '-2 day'); ?>',
                '<?= Translator::trans('admin_home_chart_previous_day'); ?>',
                "<?= Translator::trans('admin_home_chart_today'); ?>"
            ],
            datasets: [{
                label: '# <?= Translator::trans('admin_home_chart_visit'); ?>',
                data: [
                    <?= $chart_data['previous_six_day'] ?? '0'; ?>,
                    <?= $chart_data['previous_fifth_day'] ?? '0'; ?>,
                    <?= $chart_data['previous_fourth_day'] ?? '0'; ?>,
                    <?= $chart_data['previous_three_day'] ?? '0'; ?>,
                    <?= $chart_data['previous_two_day'] ?? '0'; ?>,
                    <?= $chart_data['previous_day_visit'] ?? '0'; ?>,
                    <?= AnalyticsRepository::getTodayVisit() ?? '0'; ?>
                ],
                borderColor: '#30475e',
                tension: 0.2,
                fill: true,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>