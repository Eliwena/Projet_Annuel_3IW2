<?php

namespace App\Controller\Admin\Reservation;


use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Helpers;
use App\Form\Admin\Reservation\ReservationForm;
use App\Models\Reservation;
use \App\Models\Users\User;
use App\Core\Framework;
use App\Repository\Users\UserRepository;
use App\Services\Http\Message;
use App\Services\Http\Session;
use Cassandra\Date;
use Cassandra\Time;

class ReservationController extends AbstractController
{
    public function indexAction()
    {

        $reservation = new Reservation();
        $reservations = $reservation->findAll([],['date_reservation' => 'ASC'], true);
        $this->render("admin/reservation/list", ['_title' => 'Liste des reservation', 'reservations' => $reservations], 'back');
    }

    public function deleteAction()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $reservation = new Reservation();
            $reservations = $reservation->find(['id' => $id]);

            $reservation->setId($reservations->getId());

            $reservation->delete();

            $this->redirect(Framework::getUrl('app_admin_reservation'));
        }
    }

    public function validateAction()
    {
        if (isset($_GET['id']) && isset($_GET['action'])) {

            $id = $_GET['id'];
            $action = $_GET['action'];


            $reservation = new Reservation();
            $reservation->setId($id);
            Helpers::debug($action);
            if($action == 'valide') {
                $reservation->setValidate(1);
            } else {
                $reservation->setValidate(0);
            }
            $reservation->save();


            $this->redirect(Framework::getUrl('app_admin_reservation'));
        }

    }

    public function addAction()
    {

            $form = new ReservationForm();
            $today = date('Y-m-d');
            $time = "00:00:00";
            $hour = [];

        if (isset($_GET['date_d'])) {
            $date_d = $_GET['date_d'];

            //todo select les horraires déjà inscrit
            $hour_exist = new Reservation();
            $hour_exist = $hour_exist->findAll(['date_reservation' => $date_d]);
            // on verifie si une reservation est déjà posé pour la journée si oui :
            if($hour_exist != null) {
                foreach ($hour_exist as $hour_existes) {
                    $hour_array[] = $hour_existes['hour']; // création d'un tableau avec les horraires existant
                }
                // création du tableau des horraire
                for ($i = 0; $i < 24; $i = $i + 0.5) {
                    $new_time = date('H:i:s', strtotime($time . '+ 30 minutes'));
                     if ($i >= 11 && $i <= 14 || $i >= 18.5 && $i <= 22.5) {
                                    array_push($hour, $new_time);
                        }
                    $time = $new_time;
                }
                // On supprimes les horaires déjà existant en base
                foreach ($hour_array as $hour_array_final) {
                    unset($hour[array_search($hour_array_final,$hour)]);
                }
                // On supprime les doublons
                $unique = array_unique($hour);

                // on créer l'element du select
                $select = [];
                foreach ($unique as $hours) {
                    $select[] =
                        [
                            "value" => $hours,
                            "text" => $hours,
                        ];
                }
                // on l'inject dans l'imput
                $form->setInputs([
                    'hour' => ['options' => $select]
                ]);

            } else { // Si pas d'horraire déjà entrer en base

                for ($i = 0; $i < 24; $i = $i + 0.5) {
                    $new_time = date('H:i:s', strtotime($time . '+ 30 minutes'));
                        if ($i >= 11 && $i <= 14 || $i >= 18.5 && $i <= 22.5) {
                            array_push($hour, $new_time);
                    }
                    $time = $new_time;
                }

                $unique = array_unique($hour);
                //Helpers::debug($hour);

                $select = [];
                foreach ($unique as $hours) {
                    $select[] =
                        [
                            "value" => $hours,
                            "text" => $hours,
                        ];
                }
                $form->setInputs([
                    'hour' => ['options' => $select]
                ]);
            }

        } else { // Si date_d n'existe pas

            for ($i = 0; $i < 24; $i = $i + 0.5) {
                $new_time = date('H:i:s', strtotime($time . '+ 30 minutes'));
                if ($i >= 11 && $i <= 14 || $i >= 18.5 && $i <= 22.5 ) {
                    array_push($hour, $new_time);
                }
                $time = $new_time;
            }


            $select = [];
            foreach ($hour as $hours) {
                $select[] =
                    [
                        "value" => $hours,
                        "text" => $hours,
                    ];
            }
        }

            $form->setInputs([
                'date' => ['min' => $today],
                'hour' => ['options' => $select]
            ]);


            if (!empty($_POST)) {

                $reservation = new Reservation();
                // En attendant ( verification après l'envoie si l'heure est dejà pris ou pas
                $verif_hour = $reservation->findAll(['date_reservation'=> $_POST['date']]);

                if($verif_hour != null) {
                    foreach ($verif_hour as $verif_hours) {
                        if ($verif_hours['hour'] == $_POST['hour']) {
                            Message::create('Erreur de connexion', 'L\'horraire est déjà pris pour cette date.', 'error');
                            $this->redirect(Framework::getUrl('app_admin_reservation_add'));
                        } else {
                            $validator = true;
                        }
                    }
                }else {
                    $validator = true;
                }

                if ($validator) {

                    $reservation = new Reservation();
                    //todo checkbox si déjà un compte ou non si oui entrer le nom + eamil (id dans user_id ) si non entrer juste le nom de la personne  ( nom en dure dans lastanme )

                    // --- --- GESTION USER --- --- #
                    if(isset($_POST['checkbox'])){
                    $nom = $_POST['nom'];
                    $users = new User();
                    $user = $users->find(['lastname' => $nom]);
                        $user_id = $user->getId();
                        $reservation->setUserId($user_id);

                    }else {
                        $users = new User();
                        $user = $users->find(['lastname' => "default"]);
                        $reservation->setUserId($user->getId());
                        $reservation->setLastname($_POST['nom']);
                    }
                    // --- --- END --- --- #

                    $reservation->setDateReservation($_POST['date']);
                    $reservation->setNbPeople($_POST["people"]);
                    $reservation->setHour($_POST['hour']);
                    $save = $reservation->save();

                    if ($save) {
                        $this->redirect(Framework::getUrl('app_admin_reservation'));
                    } else {
                        Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'une reservation.', 'error');
                        $this->redirect(Framework::getUrl('app_admin_reservation_add'));
                    }

                } else {
                    //liste les erreur et les mets dans la session message.error
                    if (Session::exist('message.error')) {
                        foreach (Session::load('message.error') as $message) {
                            Message::create($message['title'], $message['message'], 'error');
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_reservation_add'));
                }

            } else {
                $this->render("admin/reservation/add", ['_title' => 'Ajout d\'une reservation', "form" => $form,], 'back');
            }
        }

        public function editAction(){

            $id = $_GET['id'];

            $reservation = new Reservation();
            $reservation->setId($id);
            $reservation = $reservation->find(['id' => $id]);

            $form = new ReservationForm();
            $form->setForm([
                "submit" => "Editer une Reservation",
            ]);

            $user = new User();
            if($reservation->getLastname() != null){
                $name = $reservation->getLastname();
            }else {
                $name = $reservation->getUserId();
                $name = $name->getLastname();
            }

            $form->setInputs([
                'people' => ['value' => $reservation->getNbPeople()],
                'date'=> ['value'=>$reservation->getDateReservation(), 'type'=>'input','disabled'=>true],
                'nom'=> ['value'=>$name, 'disabled'=>true],
                'hour'=> ['value'=>$reservation->getHour(),'type'=> 'input','disabled' => true],
                'checkbox'=>['hidden'=> true]
            ]);

            if (!empty($_POST)) {

                $validator = true;

                if ($validator) {

                    $reservation = new Reservation();

                    $reservation->setNbPeople($_POST["people"]);
                    $reservation->setId($id);
                    
                    $update = $reservation->save();

                    if ($update) {
                        Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                        $this->redirect(Framework::getUrl('app_admin_reservation'));
                    } else {
                        Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                        $this->redirect(Framework::getUrl('app_admin_reservation_edit'));
                    }
                } else {
                    //liste les erreur et les mets dans la session message.error
                    if (Session::exist('message.error')) {
                        foreach (Session::load('message.error') as $message) {
                            Message::create($message['title'], $message['message'], 'error');
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_reservation_edit'));
                }

            } else {
                $this->render("admin/reservation/edit", ['_title' => 'Edition d\'une reservation', "form" => $form,], 'back');
            }
        }

}