<?php

namespace App\Repository\Review;

use App\Models\Restaurant\Menu;
use App\Models\Review\Review;
use App\Models\Review\ReviewMenu;

class ReviewMenuRepository extends ReviewMenu {

    public static function getReviewMenus(Review $review = null, Menu $menu = null) {
        $reviewMenu = new ReviewMenu();
        if(!is_null($review) && is_null($menu)) {
            return $reviewMenu->findAll(['reviewId' => $review->getId(), 'isDeleted' => false]);
        } elseif(is_null($review) && !is_null($menu)) {
            return $reviewMenu->findAll(['menuId' => $menu->getId(), 'isDeleted' => false]);
        } elseif(!is_null($review) && !is_null($menu)) {
            return $reviewMenu->find(['reviewId' => $review->getId(), 'menuId' => $menu->getId(), 'isDeleted' => false]);
        }
        return $reviewMenu->findAll(['isDeleted' => false]);
    }

}