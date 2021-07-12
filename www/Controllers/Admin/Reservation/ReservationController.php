<?php

namespace App\Controller\Admin\Reservation;


use App\Core\AbstractController;
use App\Models\Reservation;

class ReservationController extends AbstractController
{
    public function indexAction(){

        $reservation = new Reservation();
        $reservations = $reservation->findAll(['isDeleted' => false], ['date' => 'ASC'],true);

        $this->render("admin/reservation/list", ['_title' => 'Liste des reservation', 'reservations' => $reservations], 'back');
    }
}