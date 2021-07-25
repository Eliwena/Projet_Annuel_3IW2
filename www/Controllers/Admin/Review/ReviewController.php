<?php

namespace App\Controller\Admin\Review;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
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

    public function addAction(){

        $form = new ReviewForm();

        if(!empty($_POST)) {

            $review = new Review();

            $review->setEmail($_POST["email"]);
            $review->setFirstname($_POST["firstname"]);
            $review->setLastname($_POST["lastname"]);
            $review->setEmail($_POST["email"]);
            $review->setPassword(Security::passwordHash($_POST["password"]));
            $review->setCountry('fr');
            $review->setStatus(2);

            //email already exist ?
            $register = $user->find(['email' => $user->getEmail()]);

            if(!$register) {
                $save = $user->save();

                if($save) {
                    //if save get id and create group
                    if(isset($_POST['groups'])) {
                        $user = UserRepository::getUserByEmail($user);
                        foreach ($_POST['groups'] as $item) {
                            $group = GroupRepository::getGroupByName(['name' => $item]);
                            $userGroup = new UserGroup();
                            $userGroup->setUserId($user->getId());
                            $userGroup->setGroupId($group->getId());
                            $userGroup->save();
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_user'));
                } else {
                    Message::create(Translator::trans('admin_user_add_undefined_error_title'), Translator::trans('admin_user_add_undefined_error_message'), 'error');
                }
            } else {
                Message::create(Translator::trans('admin_user_add_email_exist_error_title'), Translator::trans('admin_user_add_email_exist_error_mesage'), 'error');
                $this->redirect(Framework::getCurrentPath());
            }

        } else {

            $form->setForm([
                "submit" => Translator::trans('admin_user_add_form_submit'),
                "id"     => "form_add_user",
                "method" => "POST",
                "action" => Framework::getCurrentPath(),
                "class"  => "form_control",
            ]);

            $group = new Group();
            $groups = $group->findAll();

            $group_input = [];
            foreach ($groups ? $groups : [] as $group) {
                $group_input = array_merge($group_input, [['value' => $group['name'], 'text' => $group['description']]]);
            }

            $form->setInputs([
                'password_confirm' => [ 'active' => false ],
                'groups' => [
                    "id"          => "groups",
                    'name'        => 'groups[]',
                    "type"        => "select",
                    'multiple'    => true,
                    "options"      => $group_input,
                    "label"       => Translator::trans('admin_user_add_form_input_group_label'),
                    "required"    => false,
                    "class"       => "form_input",
                    "error"       => Translator::trans('admin_user_add_form_error')
                ]
            ]);

            $this->render("admin/user/add",["form" => $form,],'back');
        }
    }

    public function deleteAction() {
        if(isset($_GET['id'])) {
            $review = ReviewRepository::getReviewById($_GET['id']);

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