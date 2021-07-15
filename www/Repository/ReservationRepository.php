<?php

namespace App\Repository;

use App\Models\Reservation;
use App\Services\Http\Cache;


class ReservationRepository extends Reservation {

    public static function getReservationToday() {
        if(Cache::exist('__reservation_today')) {
            return Cache::read('__reservation_today')['reservation_today'];
        } else {
            $reservation= new Reservation();
            $query = 'SELECT COUNT(id) AS `reservation_today` FROM ' . $reservation->getTableName() .' WHERE date_reservation = CAST(NOW() as date)';
            Cache::write('__reservation_today', $data = $reservation->execute($query));
            return $data['reservation_today'];
        }
    }





}