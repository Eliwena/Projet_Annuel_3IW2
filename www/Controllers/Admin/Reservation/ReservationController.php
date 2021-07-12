<?php

namespace App\Controller\Admin\Reservation;


use App\Core\AbstractController;
use App\Core\Helpers;
use App\Models\Reservation;
use App\Core\Framework;

class ReservationController extends AbstractController
{
    public function indexAction(){

        $reservation = new Reservation();
        $reservations = $reservation->findAll(['isDeleted' => false], ['date_reservation' => 'ASC'],true);

        $this->render("admin/reservation/list", ['_title' => 'Liste des reservation', 'reservations' => $reservations], 'back');
    }

    public function deleteAction(){
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $reservation = new Reservation();
            $reservations = $reservation->find(['id' => $id]);

            $reservation->setId($reservations->getId());

            $reservation->delete();

            $this->redirect(Framework::getUrl('app_admin_reservation'));
        }
    }
}