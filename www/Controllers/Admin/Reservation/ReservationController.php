<?php

namespace App\Controller\Admin\Reservation;


use App\Core\AbstractController;
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
        $reservations = $reservation->findAll(['isDeleted' => false], ['date_reservation' => 'ASC'], true);

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

        //todo select les horraires déjà inscrit

        for ($i = 0; $i < 24; $i = $i + 0.5) {
                        $new_time = date('H:i:s', strtotime($time . '+ 30 minutes'));
                        if ($i >= 11 && $i <= 14 || $i >= 18.5 && $i <= 22.5) {
                            array_push($hour , $new_time);
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

//        foreach ($select as $hour_select){
//            $form->setInputs([
//                'hour'=> ['options' => [$hour_select]]
//            ]);
//        }

        $form->setInputs([
            'date' => ['min' => $today],
            'hour' => ['options'=> $select]
        ]);




        if(!empty($_POST)) {

            $validator = true;

            if($validator) {

                $reservation = new Reservation();

                $nom = $_POST['nom'];

                $users = new User();
                $user = $users->find(['lastname' =>$nom]);
                if($user == null){
                    $user_id = null;
                }else {
                    $user_id = $user->getId();
                }
                //todo CREATION D'UN user SI il n'existe pas !
//                \DateTime::createFromFormat("Y-m-d",$new_date)
                $reservation->setDateReservation($_POST['date']);
                $reservation->setNbPeople($_POST["people"]);
                $reservation->setHour($_POST['hour']);
                $reservation->setUserId($user_id);
                Helpers::debug($reservation);
                $save = $reservation->save();

                if($save) {
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
}