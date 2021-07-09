<?php
use App\Services\Translator\Translator;
use \App\Repository\Users\UserRepository;
use App\Repository\AnalyticsRepository;
?>
<section class="content">
    <h1><?= Translator::trans('admin_homepage_title'); ?></h1>

    <div class="container">
        <div class="card">
            <div class="card-body card-stats">
                <span><?= Translator::trans('admin_home_card_user_registered'); ?></span>
                <span style="color: #000000"><?= UserRepository::getUserNumber() ?? '0'; ?> <i class="fas fa-user"></i></span>
            </div>
        </div>
        <div class="card">
            <div class="card-body card-stats">
                <span><?= Translator::trans('admin_home_card_visitor_today'); ?></span>
                <span style="color: #000000"><?= AnalyticsRepository::getTodayVisit() ?? '0'; ?> <?php if(AnalyticsRepository::getPreviousDayVisit() < AnalyticsRepository::getTodayVisit()) {echo '<i style="color: green" class="fas fa-arrow-up fa-rotate-45"></i>';} elseif(AnalyticsRepository::getPreviousDayVisit() < AnalyticsRepository::getTodayVisit()) {echo '<i style="color: red" class="fas fa-arrow-down fa-rotate--45"></i>';} else {echo '<i class="fas fa-equals"></i>';} ?></span>
            </div>
        </div>
        <div class="card">test</div>
        <div class="card">test</div>
        <!--canvas id="myChart" width="400" height="400"></canvas-->
    </div>

</section>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
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