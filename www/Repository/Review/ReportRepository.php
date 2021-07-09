<?php

namespace App\Repository\Review;

use App\Models\Review\Report;
use App\Models\Review\Review;

class ReportRepository extends Report {

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
        $reviews = $reports->findAll(['reviewId' => $review->getId()]);
        if($reviews) {
            return $reviews;
        } else {
            return null;
        }
    }

}