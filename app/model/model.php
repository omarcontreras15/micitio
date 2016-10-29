<?php

class Model {
    private $connection;

    public function connect(){
        $server="localhost";
        $user="root";
        $pass="";
        $bd="proyecto3";
        $this->connection = mysqli_connect($server,$user,$pass,$bd) or  die(("Error " . mysqli_error($this->connection)));
    }

    public function query($sql){
        return mysqli_query($this->connection,$sql);
    }


    public function terminate(){
        mysqli_close($this->connection);
    }

}

?>