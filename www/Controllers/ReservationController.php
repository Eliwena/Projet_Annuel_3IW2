<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Review\ReviewForm;
use App\Models\Reservation;
use App\Models\Review\Review;
use App\Repository\Review\ReviewMenuRepository;
use App\Repository\Review\ReviewRepository;
use App\Services\Front\Front;
use App\Services\Http\Session;
use App\Services\Mailer\Mailer;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class ReservationController extends AbstractController
{

    public function addAction()
    {

        if(empty($_POST)) {
            return $this->jsonResponse([
                'message' => 'direct access not allowed'
            ], 'error');
        }

        $reservation = new Reservation();
        $reservation->setNbPeople($_POST['number']);
        $reservation->setDateReservation($_POST['date']);
        $reservation->setHour($_POST['hour']);
        $reservation->setLastname(Security::getUser()->getLastname());
        $reservation->setUserId($this->getUser()->getId());

        $save = $reservation->save();

        if($save) {
            $mail = new Mailer();
            $mail->prepare($this->getUser()->getEmail(), 'Reservation', 'Une reservation pour ' . $reservation->getNbPeople() . ' le ' . $reservation->getDateReservation() . ' à ' . $reservation->getHour() . ' à bien été enrengistré.');
            $mail->send();
            return $this->jsonResponse([
                'message' => 'added',
                'data' => [
                    'numPers' => $reservation->getNbPeople(),
                    'hour' => $reservation->getHour(),
                    'date' => $reservation->getDateReservation(),
                    'create_at' => Front::date('now', 'd') . ' ' . Translator::trans(Front::date('now', 'F')) . ' ' . Front::date('now', 'Y')
                ]
            ], 'success');
        } else {
            return $this->jsonResponse([
                'message' => 'error',
            ], 'error');
        }

    }

}