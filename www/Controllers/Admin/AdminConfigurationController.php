<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Form\Admin\ConfigurationForm;
use App\Models\WebsiteConfiguration;
use App\Repository\WebsiteConfigurationRepository;
use App\Services\File\FileManager;
use App\Services\File\uploadManager;
use App\Services\Http\Message;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class AdminConfigurationController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected()) {
            Message::create($this->trans('error'), $this->trans('you_need_to_be_connected'));
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

	public function indexAction() {
        $this->isGranted('admin_panel_parameter_list');

        $_title = Translator::trans('admin_configuration_list_title');
        $form = new ConfigurationForm();
        $configurations = WebsiteConfigurationRepository::getConfigurations();

        $this->render("admin/configuration/index", compact('form', 'configurations', '_title'),'back');
    }

    public function editAction() {
        $this->isGranted('admin_panel_parameter_edit');

        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $_title = Translator::trans('admin_configuration_edit_title');
            $form = new ConfigurationForm();
            $configuration = WebsiteConfigurationRepository::getConfigurationById($_GET['id']);

            if(!$configuration) {
                Message::create(Translator::trans('error'), Translator::trans('admin_configuration_not_exist_message', ['id' => $_GET['id']]));
                $this->redirectToRoute('app_admin_config');
            }

            if (!empty($_POST) || !empty($_FILES)) {

                if(isset($_POST['value']) && $_POST['value'] == $configuration->getValue()) {
                    Message::create(Translator::trans('admin_configuration_no_edit_title'), Translator::trans('admin_configuration_no_edit_message'), 'info');
                    $this->redirect(Framework::getUrl('app_admin_config'));
                    return null;
                }

                $c = new WebsiteConfiguration();

                if(isset($_POST['value'])) {
                    $c->setValue($_POST['value']);
                }

                if(isset($_FILES['value'])) {
                    //remove old file
                    $uploadManager = new uploadManager();
                    $uploadManager->setMimeTypesAuthorized(['image/x-icon']);
                    $uploadManager->setFile($_FILES['value']);

                    if(!$uploadManager->isTypeAuthorized()) {
                        Message::create(Translator::trans('admin_file_upload_mime_type_unauthorized_title'), Translator::trans('admin_file_upload_mime_type_unauthorized_message'), 'error');
                        $this->redirect(Framework::getUrl('app_admin_config_edit', ['id' => $_GET['id']]));
                    }

                    if(!$uploadManager->validateFileSize()) {
                        Message::create(Translator::trans('admin_file_upload_max_size_increase_title'), Translator::trans('admin_file_upload_max_size_increase_message', ['size' => FileManager::formatBytes($uploadManager->getFileSize()), 'max_size' => FileManager::formatBytes($uploadManager->getMaxFileSize())]), 'error');
                        $this->redirect(Framework::getUrl('app_admin_config_edit', ['id' => $_GET['id']]));
                    }

                    if($uploadManager->validateFileSize() && $uploadManager->isTypeAuthorized()) {
                        FileManager::remove(uploadManager::getDefaultSavePath() . $configuration->getValue());
                        $c->setValue($uploadManager->getNewFileName() . '.' . $uploadManager->getFileExtension());
                        $uploadManager->save();
                    }
                }

                $c->setId($configuration->getId());
                $update = $c->save();

                if ($update) {
                    Message::create(Translator::trans('success'), Translator::trans('admin_configuration_update_success_message', ['name' => $configuration->getDescription()]), 'success');
                    $this->redirect(Framework::getUrl('app_admin_config'));
                } else {
                    Message::create(Translator::trans('error'), Translator::trans('admin_configuration_update_error_message'), 'error');
                    $this->redirect(Framework::getUrl('app_admin_config'));
                }

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
                // numeric phone number form
                elseif($configuration->getName() == 'phone_number') {
                    $form->setInputs([
                        'value' => [
                            'label' => $configuration->getDescription(),
                            'value' => $configuration->getValue(),
                            'type' => 'number'
                        ]
                    ]);
                }
                // site logo
                elseif($configuration->getName() == 'site_logo' || $configuration->getName() == 'site_favicon') {
                    $form->setForm(['enctype' => 'multipart/form-data']);
                    $form->setInputs([
                        'value' => [
                            'label' => $configuration->getDescription(),
                            'value' => $configuration->getValue(),
                            'type' => 'file'
                        ]
                    ]);
                }
                // default input for all parameter
                else {
                    $form->setInputs([
                        'value' => [
                            'label' => $configuration->getDescription(),
                            'value' => $configuration->getValue(),
                        ]
                    ]);
                }

                $this->render('admin/configuration/edit', compact('form', '_title'), 'back');
            }

        } else {
            Message::create(Translator::trans('error'), Translator::trans('an_identifier_is_expected'), 'error');
            $this->redirect(Framework::getUrl('app_admin_config'));
        }
    }


}
