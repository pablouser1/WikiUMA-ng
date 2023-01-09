<?php
namespace App\Helpers;

class Subject {
    static public function join(int $asignatura_id, int $plan_id): string {
        return $asignatura_id . ';' . $plan_id;
    }

    static public function split(string $data): ?object {
        // Separar id e id del plan
        // 0: id asignatura
        // 1: id plan
        $asig_arr = explode(';', $data);
        // Nos aseguramos que sea exactamente dos elementos
        if (count($asig_arr) !== 2) {
            return null;
        }

        $subject = new \stdClass;
        $subject->asig = $asig_arr[0];
        $subject->plan = $asig_arr[1];

        return $subject;
    }
}
