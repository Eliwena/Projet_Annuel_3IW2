<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Report\ReportForm;
use App\Form\Admin\Review\ReviewForm;
use App\Models\Review\Report;
use App\Models\Review\Review;
use App\Models\Review\ReviewMenu;
use App\Repository\Review\ReviewMenuRepository;
use App\Repository\Review\ReviewRepository;
use App\Services\Front\Front;
use App\Services\Http\Session;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class ReviewController extends AbstractController
{

    public function indexAction() {
        $reviews = ReviewRepository::getReviews();
        $menuReviews = ReviewMenuRepository::getReviewMenus();

        $form = new ReviewForm();
        $form->setForm(['action' => Framework::getUrl('app_review_add')]);
//        $form_report = new ReportForm();
//        $form_report->setForm(['action' => Framework::getUrl('app_review_report')]);
//        $form_report->setInputs();
        $this->render('reviews', compact('form', 'reviews', 'menuReviews'), 'front');
    }

    public function addAction() {

        if(empty($_POST)) {
            return $this->jsonResponse([
                'message' => 'direct access not allowed'
            ], 'error');
        }

        $form = new ReviewForm();
        $validator = FormValidator::validate($form, $_POST);

        if($validator) {

            $review = new Review();
            $review->setTitle($_POST['title']);
            $review->setText($_POST['text']);
            $review->setNote($_POST['note']);
            $review->setUserId(Security::getUser()->getId());

            $save = $review->save();

            if(isset($_POST['menuId']) && !empty($_POST['menuId'])) {
                $reviewId = new Review();
                $reviewId = $reviewId->find(['userId'=>$this->getUser()->getId(), 'text'=>$review->getText(), 'title'=>$review->getTitle(), 'note'=>$review->getNote()]);
                $menuReview = new ReviewMenu();
                $menuReview->setMenuId($_POST['menuId']);
                $menuReview->setReviewId($reviewId->getId());
                $menuReview->save();
            }

            if($save) {
                return $this->jsonResponse([
                    'message' => 'added',
                    'data' => [
                        'title' => $review->getTitle(),
                        'text' => $review->getText(),
                        'note' => Front::generateStars($review->getNote()),
                        'create_at' => Front::date('now', 'd') . ' ' . Translator::trans(Front::date('now', 'F')) . ' ' . Front::date('now', 'Y')
                    ]
                ], 'success');
            } else {
                return $this->jsonResponse([
                    'message' => 'error',
                ], 'error');
            }

        } else {
            return $this->jsonResponse([
                'message' => Session::exist('message') ? Session::flash('message') : '',
            ], 'error');
        }

    }

    public function reportAction() {

        if(empty($_POST)) {
            return $this->jsonResponse([
                'message' => 'direct access not allowed'
            ], 'error');
        }

        if(!empty($_POST)) {

            $report = new Report();
            $report->setReason($_POST['reason']);
            $report->setReviewId($_POST['reviewId']);

            $save = $report->save();
            $this->redirectToRoute('app_reviews');
            if($save) {
                return $this->jsonResponse([
                    'message' => 'added',
                    'data' => [
                        'reason' => $report->getReason(),
                        'reviewId' => $report->getReviewId(),
                        'create_at' => Front::date('now', 'd') . ' ' . Translator::trans(Front::date('now', 'F')) . ' ' . Front::date('now', 'Y')
                    ]
                ], 'success');
            } else {
                return $this->jsonResponse([
                    'message' => 'error',
                ], 'error');
            }

        } else {
            return $this->jsonResponse([
                'message' => Session::exist('message') ? Session::flash('message') : '',
            ], 'error');
        }

    }

}