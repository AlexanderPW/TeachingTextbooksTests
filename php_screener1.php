<?php
class TimelyGreeting {

public function theGreeter() {

    $greeting = 'Good';
    //Headquarters in Oklahoma City
    $latitude  = 35.534000;
    $longitude = -97.518000;

    $time = $this->getDayOrNight($latitude, $longitude);
    $person = $this->getPerson();

    return "$greeting $time $person.";
}

protected function getPerson() {
    $person = 'stranger';
    if(!isset($_COOKIE['username'])) {
        //Testing cookie checks...
        /*setcookie('username', 'Greg');
        $_COOKIE['username'] = 'Greg';
        $person = $_COOKIE['username'];*/
        return $person;
    }
    else {
        return $_COOKIE['username'];
    }
}

protected function getDayOrNight($latitude, $longitude) {
    $now       = time();
    $time = '';

    if ($latitude && $longitude) {
        $sun    = date_sun_info ( $now, $latitude, $longitude);
        $light  = $sun['civil_twilight_begin'];
        $dark   = $sun['civil_twilight_end'];

        if (($now > $light && $now < $dark)) {
            $time = 'day';
        } else {
            $time = 'night';
        }
        return $time;
    } else {
        //do error handling here
        return null;
    }
}
}

$someone = new TimelyGreeting();
echo $someone->theGreeter();

