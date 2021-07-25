<?php

namespace App\Controller\Admin\Review;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Review\ReviewForm;
use App\Models\Review\Report;
use App\Models\Review\Review;
use App\Models\Review\ReviewMenu;
use App\Repository\Review\ReportRepository;
use App\Repository\Review\ReviewMenuRepository;
use App\Repository\Review\ReviewRepository;
use App\Services\Http\Cache;
use App\Services\Http\Message;
use App\Services\Http\Router;

class ReviewController extends AbstractController
{

    public function indexAction(){
        $reviews = ReviewRepository::getReviews();
        $this->render("admin/review/list", ['reviews' => $reviews], 'back');
    }

    public function showAction() {
        if(isset($_GET['id'])) {
            $review = ReviewRepository::getReviews($_GET['id']);
            if($review) {
                $this->render("admin/review/show", ['review' => $review], 'back');
            } else {
                Message::create('Error', 'Commentaire existe pas');
                $this->redirect(Framework::getUrl('app_admin_review'));
            }
        } else {
            Message::create('Error', 'Identifiant introuvable');
            $this->redirect(Framework::getUrl('app_admin_review'));
        }
    }

    public function deleteAction() {
        if(isset($_GET['id'])) {
            $review = ReviewRepository::getReviewById($_GET['id']);
            $review->setUserId(null);

                //init data
                $reviewMenus = ReviewMenuRepository::getReviewMenus($review);
                $reports = ReportRepository::getReportByReviewId($review);

                //delete all reviewmenu associate
                if($reviewMenus) {
                    foreach ($reviewMenus as $reviewMenu) {
                        $rm = new ReviewMenu();
                        $rm->setId($reviewMenu['id']);
                        $rm->setIsDeleted(1);
                        $rm->save();
                    }
                }

                //delete report associate
                if($reports) {
                    foreach ($reports as $report) {
                        $r = new Report();
                        $r->setId($report['id']);
                        $r->setIsDeleted(1);
                        $r->save();
                    }
                }

                //delete group
            $review->setIsDeleted(1);

            $review->save();
            Cache::clear('app_admin_review');
            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_review'));
        }
        else {
            Message::create('Warning', 'Identifiant introuvable');
            $this->redirect(Framework::getUrl('app_admin_review'));
        }
    }

}