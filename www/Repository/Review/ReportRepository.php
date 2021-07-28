<?php

namespace App\Repository\Review;

use App\Core\Helpers;
use App\Models\Review\Report;
use App\Models\Review\Review;
use App\Services\Http\Cache;
use App\Services\Http\Router;

class ReportRepository extends Report {

    private static function map($report) {
        if(is_array($report)) {
            $_report = new Report();
            $report = $_report->populate($report,false);
        }elseif(is_int($report) || is_string($report)) {
            $_report = new Report();
            $_report->setId($report);
            $report = $_report->populate(['id' => $report], false);
        }
        return $report;
    }

    public static function getReport($report = null) {
        $reports = new Report();
        $report = self::map($report);

        //si review null alors findAll avec cache
        is_null($report) ? (Cache::exist(Router::getCurrentRoute(), '*') ?
            $response = Cache::read(Router::getCurrentRoute(), '*')
            : Cache::write(Router::getCurrentRoute(), $response = $reports->findAll(['isDeleted' => false], ['createAt' => 'DESC']), '*')
        ) : $response = $reports->find(['id' => $report->getId(), 'isDeleted' => false], ['createAt' => 'DESC']);

        return $response;
    }

    public static function getReportByReviewId($review) {
        if(is_array($review)) {
            $_review = new Review();
            $review = $_review->populate($review, false);
        }elseif(is_int($review) || is_string($review)) {
            $_review = new Review();
            $_review->setId($review);
            $review = $_review->populate(['id' => $review], false);
        }
        $reports = new Report();
        $report = $reports->findAll(['reviewId' => $review->getId()]);
        if($report) {
            return $report;
        } else {
            return null;
        }
    }

}