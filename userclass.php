<?php
  class user{
    var $id;
    var $uname;
    var $name;
    var $img;
    var $fccurl;
    var $apiurl;
    var $points;
    var $rank;

    function _construct($id,$uname,$img,$name){
      echo "i am in\n";
      $this->id=$id;
      $this->uname=$uname;
      $this->name=$name;
      $this->img=$img;
      $this->fccurl="https://www.freecodecamp.com/".$uname;
      $this->apiurl="https://www.freecodecamp.com/api/users/about?username=".$uname;
      $this->points=$this->pointsFetcher();
      echo "i am out\n";
    }

    function pointsFetcher(){
      $result=file_get_contents($this->apiurl);
      $object = json_decode($result);
      try{
        return $object[0]->browniePoints;
      }catch(Exception $e){
        return 0;
      }
    }
  }

 ?>
