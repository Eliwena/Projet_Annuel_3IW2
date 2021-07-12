<?php

namespace App\Controller\Admin\Reservation;


use App\Core\AbstractController;
use App\Core\Helpers;
use App\Models\Reservation;
use App\Core\Framework;

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


}