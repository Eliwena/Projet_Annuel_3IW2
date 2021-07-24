<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\ConfigurationForm;
use App\Models\WebsiteConfiguration;
use App\Repository\WebsiteConfigurationRepository;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class AdminConfigurationController extends AbstractController
{
	public function indexAction() {
        if(!Security::hasPermissions('admin_panel_parameter_list')) {
            Message::create(Translator::trans('access_denied_title'), Translator::trans('access_denied_message'));
            $this->redirectToRoute('app_admin');
        }

        $_title = Translator::trans('admin_configuration_list_title');
        $form = new ConfigurationForm();
        $configurations = WebsiteConfigurationRepository::getConfigurations();

        $this->render("admin/configuration/index", compact('form', 'configurations', '_title'),'back');
    }

    public function editAction() {
        if(!Security::hasPermissions('admin_panel_parameter_edit')) {
            Message::create(Translator::trans('access_denied_title'), Translator::trans('access_denied_message'));
            $this->redirectToRoute('app_admin');
        }

        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $_title = Translator::trans('admin_configuration_edit_title');
            $form = new ConfigurationForm();
            $configuration = WebsiteConfigurationRepository::getConfigurationById($_GET['id']);

            if(!$configuration) {
                Message::create(Translator::trans('admin_configuration_not_exist_title'), Translator::trans('admin_configuration_not_exist_message', ['id' => $_GET['id']]));
                $this->redirectToRoute('app_admin_config');
            }

            if (!empty($_POST)) {

                if(isset($_POST['value']) && $_POST['value'] == $configuration->getValue()) {
                    Message::create(Translator::trans('admin_configuration_no_edit_title'), Translator::trans('admin_configuration_no_edit_message'), 'info');
                    $this->redirect(Framework::getUrl('app_admin_config'));
                    return null;
                }

                $c = new WebsiteConfiguration();
                $c->setId($configuration->getId());
                $c->setValue($_POST['value']);
                $update = $c->save();

                if ($update) {
                    Message::create(Translator::trans('admin_configuration_update_success_title'), Translator::trans('admin_configuration_update_success_message', ['name' => $configuration->getDescription()]), 'success');
                    $this->redirect(Framework::getUrl('app_admin_config'));
                } else {
                    Message::create(Translator::trans('admin_configuration_update_error_title'), Translator::trans('admin_configuration_update_error_message'), 'error');
                    $this->redirect(Framework::getUrl('app_admin_config'));
                }
                Helpers::debug($_POST);
                Helpers::debug($c);

            } else {
                //select options for locale
                if($configuration->getName() == 'locale') {
                    foreach (Translator::getLocaleInstalled() as $lang) {
                        if ($configuration->getValue() == $lang):
                            $language[] = [
                                'value' => $lang,
                                'text' => strtoupper($lang),
                                'selected' => true,
                            ];
                        else:
                            $language[] = [
                                'value' => $lang,
                                'text' => strtoupper($lang),
                            ];
                        endif;
                    }

                    $form->setInputs([
                        'value' => [
                            'type' => 'select',
                            'label' => $configuration->getDescription(),
                            "options" => $language,
                        ]
                    ]);

                }
                // boolean form
                elseif($configuration->getValue() == 'false' or $configuration->getValue() == 'true') {
                    if ($configuration->getValue() == 'false'):
                        $options[] = ['value' => 'false', 'text' => Translator::trans('disable'), 'selected' => true];
                        $options[] = ['value' => 'true', 'text' => Translator::trans('enable')];
                    else:
                        $options[] = ['value' => 'false', 'text' => Translator::trans('disable')];
                        $options[] = ['value' => 'true', 'text' => Translator::trans('enable'), 'selected' => true];
                    endif;

                    $form->setInputs([
                        'value' => [
                            'type' => 'select',
                            'label' => $configuration->getDescription(),
                            "options" => $options,
                        ]
                    ]);
                }
                // default input for all parameter
                else {
                    $form->setInputs([
                        'value' => [
                            'label' => $configuration->getDescription(),
                            'value' => $configuration->getValue()
                        ]
                    ]);
                }

                $this->render('admin/configuration/edit', compact('form', '_title'), 'back');
            }

        } else {
            Message::create(Translator::trans('admin_configuration_id_empty_title'), Translator::trans('admin_configuration_id_empty_message'), 'error');
            $this->redirect(Framework::getUrl('app_admin_config'));
        }
    }


}
