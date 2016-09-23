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

    function __construct($id,$uname,$img,$name){
      echo "i am in\n";
      $this->id=$id;
      $this->uname=$uname;
      $this->name=$name;
      $this->img=$img;
      $this->fccurl="https://www.freecodecamp.com/".$uname;
      $this->apiurl="https://www.freecodecamp.com/api/users/about?username=".$uname;
      $this->points = self::pointsFetcher();
      echo "i am out\n";
    }

    function pointsFetcher(){
      try{
      $result=file_get_contents($this->apiurl);
      $object = json_decode($result);
      echo "got the data\n";
      if(property_exists($object, "about"))
         return empty($object->about->browniePoints) ? 0 : $object->about->browniePoints;
      else
        return 0;
      }catch(Exception $e){
      }
    }
  }

 ?>
