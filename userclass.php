<?php
  class user{
    var $id;
    var $uname;
    var $name;
    var $fccurl;
    var $apiurl;
    var $points;

    function __construct($id,$uname,$name){
      echo "i am in\n";
      $this->id=$id;
      $this->uname=$uname;
      $this->name=$name;
      $this->fccurl="https://www.freecodecamp.com/".$uname;
      $this->apiurl="https://www.freecodecamp.com/api/users/about?username=".strtolower($uname);
      $this->points ;//= self::pointsFetcher();
      echo "i am out\n";
    }

    function pointsFetcher(){
      try{
      /*$result=file_get_contents($this->apiurl);
      $object = json_decode($result);
      echo "got the data\n";*/


      //  Initiate curl
      $ch = curl_init();
      // Disable SSL verification
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      curl_setopt($ch, CURLOPT_URL,$this->apiurl);
      // Execute
      $object=curl_exec($ch);
      // Closing
      curl_close($ch);

      // Will dump a beauty json :3
      var_dump(json_decode($object, true));

      if(property_exists($object, "about"))
         return empty($object->about->browniePoints) ? 0 : $object->about->browniePoints;
      else
        return 0;
      }catch(Exception $e){
      }
    }
  }

 ?>
