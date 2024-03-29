<?php

namespace App\Controller\Admin\Page;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Router;
use App\Form\Admin\Page\PageForm;
use App\Models\Page\Page;
use App\Repository\Page\PageRepository;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class PageController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected()) {
            Message::create($this->trans('error'), $this->trans('you_need_to_be_connected'));
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

    public function indexAction(){
        $this->isGranted('admin_panel_page_list');
        $pages = PageRepository::getPages();
        $this->render("admin/page/list", ['pages' => $pages], 'back');
    }

    public function addAction() {
        $this->isGranted('admin_panel_page_add');

        $form = new PageForm();

        if (!empty($_POST)) {

            if (FormValidator::validate($form, $_POST)) {

                $page = new Page();
                $page->setName($_POST['name']);
                $page->setMetaDescription($_POST['meta_description']);
                $page->setSlug(\App\Services\Http\Router::formatSlug($_POST['slug']));
                $page->setContent(base64_encode($_POST['content']));
                $save = $page->save();

                if ($save) {
                    $this->redirect(Framework::getUrl('app_admin_page'));
                } else {
                    foreach ($_POST as $k => $i) {
                        Session::create('form_page_'.$k, $i);
                    }
                    Message::create(Translator::trans('error'), Translator::trans('admin_page_add_error_message'), 'error');
                    $this->redirect(Framework::getUrl('app_admin_page_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                Message::create(Translator::trans('error'), Translator::trans('admin_page_add_error_message'), 'error');
                $this->redirect(Framework::getUrl('app_admin_page_add'));
            }

        } else {
            $this->render("admin/page/add", ['_title' => 'Ajout d\'une page', "form" => $form,], 'back');
        }
    }

    public function editAction()
    {
        $this->isGranted('admin_panel_page_edit');

        if (isset($_GET['id'])) {

            $form = new PageForm();

            if (!empty($_POST)) {

                if (FormValidator::validate($form, $_POST)) {

                    $page = new Page();
                    $pageRepository = PageRepository::getPages($_GET['id']);

                    if (isset($_POST['name']) && $_POST['name'] != $pageRepository->getName()) {
                        $page->setName($_POST["name"]);
                    }
                    if (isset($_POST['meta_description']) && $_POST['meta_description'] != $pageRepository->getMetaDescription()) {
                        $page->setMetaDescription($_POST['meta_description']);
                    }
                    if (isset($_POST['slug']) && $_POST['slug'] != $pageRepository->getSlug()) {
                        $page->setSlug(\App\Services\Http\Router::formatSlug($_POST["slug"]));
                    }
                    $page->setContent(base64_encode($_POST["content"]));

                    $page->setId($pageRepository->getId());
                    $update = $page->save();

                    if ($update) {
                        Message::create(Translator::trans('update'), Translator::trans('admin_page_update_success_message'), 'success');
                        $this->redirect(Framework::getUrl('app_admin_page'));
                    } else {
                        Message::create(Translator::trans('error'), Translator::trans('admin_page_add_error_message'), 'error');
                        $this->redirect(Framework::getUrl('app_admin_page'));
                    }
                } else {
                    Message::create(Translator::trans('error'), Translator::trans('admin_page_add_error_message'), 'error');
                    $this->redirect(Framework::getUrl('app_admin_page'));
                }

            } else {
                $page = PageRepository::getPages($_GET['id']);
                $form->setForm(['submit' => Translator::trans('admin_page_edit_title')]);
                $form->setInputs(['name' => ['value' => $page->getName()], 'meta_description' => ['value' => $page->getMetaDescription()], 'slug' => ['value' => \App\Services\Http\Router::formatSlug($page->getSlug())], 'content' => ['value' => base64_decode($page->getContent())]]);
                $this->render("admin/page/edit", ['content' => $page->getContent(), '_title' => Translator::trans('admin_page_edit_title'), "form" => $form], 'back');
            }
        }  else {
            Message::create(Translator::trans('error'), Translator::trans('an_identifier_is_expected'), 'error');
            $this->redirect(Framework::getUrl('app_admin_page'));
        }
    }


    public function deleteAction() {
        $this->isGranted('admin_panel_page_delete');

        if (isset($_GET['id'])) {
            $pageRepository = PageRepository::getPages($_GET['id']);
            $page = new Page();
            $page->setId($pageRepository->getId());
            $page->setIsDeleted(true);
            $page->setIsActive(false);
            $save = $page->save();
            if($save) {
                $this->redirect(Framework::getUrl('app_admin_page'));
            }
        } else {
            Message::create(Translator::trans('error'), Translator::trans('an_identifier_is_expected'), 'error');
            $this->redirect(Framework::getUrl('app_admin_page'));
        }
    }

}