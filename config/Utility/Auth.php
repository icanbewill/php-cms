<?php

class Auth {

    //Si quelqu'un est connecté
    public static function checkAuthenticated($redirect = "login") {
        Session::init();
        if (!Session::exists(Config::get("SESSION_USER"))) {
            Session::destroy();
            Redirect::to($redirect);
        }
    }

    //SI personne n'est connecté
    public static function checkUnauthenticated($redirect = "modeles") {
        Session::init();
        // var_dump(Session::exists(Config::get("SESSION_USER")));
        if (Session::exists(Config::get("SESSION_USER"))) {
            Redirect::to($redirect);
        }
    }

    public static function decideView(){
        Session::init();
        if (Session::exists(Config::get("SESSION_USER"))) {
            return true;
        }
        return false;
    }

}
