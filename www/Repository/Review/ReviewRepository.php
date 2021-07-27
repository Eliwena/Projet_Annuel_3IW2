<?php

namespace App\Repository\Review;

use App\Core\Helpers;
use App\Models\Review\Review;
use App\Services\Http\Cache;
use App\Services\Http\Router;
use App\Models\Review\ReviewMenu;

class ReviewRepository extends Review {

    const CACHE_PREFIXE = '__reviews_';

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


    public static function getTodayVisit() {
        if(Cache::exist(self::CACHE_PREFIXE.'_comment')) {
            return Cache::read(self::CACHE_PREFIXE.'_comment')['comment_number'];
        } else {
            $review = new Review();
            $query = 'SELECT COUNT(DISTINCT `id`) AS `comment_number` FROM ' . $review->getTableName() . " WHERE isDeleted = false AND isActive = true";
            Cache::write(self::CACHE_PREFIXE.'_comment', $data = $review->execute($query));
            return $data['comment_number'] ?? null;
        }
    }

    public static function getReviewByLastTen()
    {
            $review = new Review();
            $review_menu = new ReviewMenu();
            $query = 'SELECT '.$review->getTableName().'.id, userId, title, text, note, '.$review->getTableName().'.createAt FROM '.$review->getTableName().' where '.$review->getTableName().'.id NOT IN (SELECT reviewId FROM '.$review_menu->getTableName().') ORDER BY '.$review->getTableName().'.createAt ASC Limit 10';
            $data = $review->executeFetchAll($query);
            return $data;


    }
}