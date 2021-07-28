<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\NavigationForm;
use App\Models\Navigation;
use App\Models\Page\Page;
use App\Repository\Page\PageRepository;
use App\Services\Http\Message;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class AdminNavigationController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected()) {
            Message::create($this->trans('error'), $this->trans('you_need_to_be_connected'));
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

	public function listAction() {
        $this->isGranted('admin_panel_navigation_list');

        $_title = Translator::trans('app_admin_navigation');
        $form = new NavigationForm();

        $navigation = new Navigation();
        $navigations = $navigation->findAll();

        $this->render("admin/navigation/index", compact('form', 'navigations', '_title'),'back');
    }

    public function addAction() {
        $this->isGranted('admin_panel_navigation_add');

        if(!empty($_POST)) {
            $navigation = new Navigation();
            $navigation->setName($_POST['name']);
            $navigation->setNavOrder($_POST['navOrder']);
            $navigation->setValue($_POST['value']);

            $navigation->save();

            Message::create(Translator::trans('success'), Translator::trans('new_nav'), 'success');
            $this->redirect(Framework::getUrl('app_admin_navigation'));

        } else {
            $form = new NavigationForm();

            $navi = [
                ['value' => '/', 'text' => 'Accueil'],
                ['value' => '/contact', 'text' => 'Contact'],
                ['value' => '/reviews', 'text' => 'Avis'],
                ['value' => '/menus', 'text' => 'Menus'],
            ];

            foreach ($navi as $item) {
                $nav[] = $item;
            }

            foreach (PageRepository::getPages() ? PageRepository::getPages() : [] as $page) {
                $nav[] = [
                    'value' => '/page/' . $page['slug'],
                    'text' => $page['name']
                ];
            }

            $form->setForm(['submit' => Translator::trans('admin_navigation_form_add')]);
            $form->setInputs([
                'value' => [
                    'type' => 'select',
                    'label' => 'Valeur',
                    "options" => $nav,
                ]
            ]);

            $this->render('admin/navigation/add', compact('form'), 'back');
        }
    }

    public function deleteAction() {
        $this->isGranted('admin_panel_navigation_delete');

        if(!empty($_GET['id'])) {
            $navigation = new Navigation();
            $navigations = $navigation->find(['id' => $_GET['id']]);

            $navigations->delete();
        }
        $this->redirectToRoute('app_admin_navigation');
    }




}
