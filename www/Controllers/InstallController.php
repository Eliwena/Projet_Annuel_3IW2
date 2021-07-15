<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\ConstantManager;
use App\Core\Framework;
use App\Core\Installer;
use App\Form\Admin\User\RegisterForm;
use App\Form\InstallForm;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Services\File\FileManager;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class InstallController extends AbstractController
{

	public function installAction() {

	    if(!ConstantManager::envExist() && Installer::isPHPVersionCompatible() && Installer::isPDOExtInstalled()) {

            //step 2
            if(isset($_GET['step']) && $_GET['step'] == 2) {

                //if parameters send
                if(!empty($_POST)) {
                    foreach ($_POST as $key => $item) {
                        Session::create('form_install_' . $key, $item);
                    }

                    Installer::checkDatabase(
                        $_POST['dbhost'],
                        $_POST['dbname'],
                        $_POST['dbport'],
                        $_POST['dbuser'],
                        $_POST['dbpass']
                    );

                    $form = new RegisterForm();
                    $form->setForm(['submit' => 'Lancement de la création', 'action' => Framework::getUrl('app_install', ['step' => 3])]);
                    $this->render('install', [
                        'title' => Translator::trans('app_install_title'),
                        'form' => $form,
                        'step_title' => 'Base de données',
                    ], 'install');
                } else {
                    Message::create('Erreur', 'Formulaire erroné');
                    $this->redirectToRoute('app_install');
                }

            } elseif(isset($_GET['step']) && $_GET['step'] == 3) {

                if(!empty($_POST)) {
                    //generate env file
                    $env = [
                        'DBNAME'    => Session::flash('form_install_dbname'),
                        'DBPORT'    => Session::flash('form_install_dbport'),
                        'DBHOST'    => Session::flash('form_install_dbhost'),
                        'DBUSER'    => Session::flash('form_install_dbuser'),
                        'DBPASS'    => Session::flash('form_install_dbpass'),
                        'DBPREFIXE' => Session::flash('form_install_dbprefixe'),
                        'DBDRIVER'  => 'mysql',
                        'ENV'       => _ENV,
                    ];

                    foreach ($env as $key => $item) {
                        FileManager::append(_ENV_PATH, "$key=$item");
                    }

                    new ConstantManager();

                    Installer::install();
                    sleep(0.5);

                    //todo //check if table already exist

                    //create admin user and add to group admin
                    $user = new User();
                    $user->setEmail($_POST['email']);
                    $user->setFirstname($_POST['firstname']);
                    $user->setLastname($_POST['lastname']);
                    $user->setPassword(Security::passwordHash($_POST['password']));
                    $user->setCountry('fr');
                    $user->setStatus(1);
                    $user->save();

                    $userGroup = new UserGroup();
                    $userGroup->setUserId(1);
                    $userGroup->setGroupId(1);
                    $userGroup->save();

                    //remove form parameters
                    Session::destroy();

                    //redirect to home after installation
                    Message::create('Bienvenue', 'L\'installation de votre CMS à été effectué avec succès.');
                    $this->redirectToRoute('app_home');

                } else {
                    Message::create('Erreur', 'Formulaire erroné');
                    $this->redirectToRoute('app_install');
                }

            } else {
                $form = new InstallForm();
                $form->setForm(['action' => Framework::getUrl('app_install', ['step' => 2])]);
                $this->render('install', [
                    'title' => Translator::trans('app_install_title'),
                    'form' => $form,
                    'step_title' => 'Base de données',
                ], 'install');
            }
        } else {
            Message::create('Erreur', 'Accès refusé');
            $this->redirectToRoute('app_home');
        }
    }

}