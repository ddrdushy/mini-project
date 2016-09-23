<?php
  class user{
    var $id;
    var $uname;
    var $img;
    var $fccurl;
    var $apiurl;
    var $points;
    var $rank;

    function _construct($id,$uname,$img){
      $this->id=$id;
      $this->uname=$uname;
      $this->img=$img;
      $this->fccurl="https://www.freecodecamp.com/".$uname;
      $this->apiurl="https://www.freecodecamp.com/api/users/about?username=".$uname;
      $this->points=$this->pointsFetcher();
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
