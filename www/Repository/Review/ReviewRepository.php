<?php

namespace App\Repository\Review;

use App\Core\Helpers;
use App\Models\Review\Review;
use App\Services\Http\Cache;
use App\Services\Http\Router;

class ReviewRepository extends Review {

    private static function map($review) {
        if(is_array($review)) {
            $_review = new Review();
            $review = $_review->populate($review,false);
        }elseif(is_int($review) || is_string($review)) {
            $_review = new Review();
            $_review->setId($review);
            $review = $_review->populate(['id' => $review], false);
        }
        return $review;
    }

    public static function getReviews($review = null) {
        $reviews = new Review();
        $review = self::map($review);

        //si review null alors findAll avec cache
        is_null($review) ? (Cache::exist(Router::getCurrentRoute(), '*') ?
            $response = Cache::read(Router::getCurrentRoute(), '*')
            : Cache::write(Router::getCurrentRoute(), $response = $reviews->findAll(['isDeleted' => false], ['createAt' => 'DESC']), '*')
        ) : $response = $reviews->find(['id' => $review->getId(), 'isDeleted' => false], ['createAt' => 'DESC']);

        return $response;

    }

    public static function getReviewById($review) {
        $review = self::map($review);
        return $review->find(['id' => $review->getId()]) ?? null;
    }

}