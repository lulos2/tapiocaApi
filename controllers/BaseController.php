<?php
class BaseController{

    public function redirectRoute($route){
        header("Location: ". BASE_URL . $route);
    }
}
?>