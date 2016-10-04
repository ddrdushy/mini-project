<?php 
	function multiRequest($data, $options = array()) {
	 
	  // array of curl handles
	  $curly = array();
	  // data to be returned
	  $result = array();
	 
	  // multi handle
	  $mh = curl_multi_init();
	 
	  // loop through $data and create curl handles
	  // then add them to the multi-handle
	  foreach ($data as $id => $d) {
	 
	    $curly[$id] = curl_init();
	 
	    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
	    curl_setopt($curly[$id], CURLOPT_URL,            $url);
	    curl_setopt($curly[$id], CURLOPT_HEADER,         0);
	    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
	 
	    // post?
	    if (is_array($d)) {
	      if (!empty($d['post'])) {
		curl_setopt($curly[$id], CURLOPT_POST,       1);
		curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
	      }
	    }
	 
	    // extra options?
	    if (!empty($options)) {
	      curl_setopt_array($curly[$id], $options);
	    }
	 
	    curl_multi_add_handle($mh, $curly[$id]);
	  }
	 
	  // execute the handles
	  $running = null;
	  do {
	    curl_multi_exec($mh, $running);
	  } while($running > 0);
	 
	 
	  // get content and remove handles
	  foreach($curly as $id => $c) {
	    $result[$id] = curl_multi_getcontent($c);
	    curl_multi_remove_handle($mh, $c);
	  }
	 
	  // all done
	  curl_multi_close($mh);
	 
	  return $result;
	}
	 


$data = array(
  'https://www.freecodecamp.com/api/users/about?username=ddrdushy',
  'https://www.freecodecamp.com/api/users/about?username=kgashok',
  'https://www.freecodecamp.com/api/users/about?username=dyson94',
  'https://www.freecodecamp.com/api/users/about?username=sathishkumar5',
  'https://www.freecodecamp.com/api/users/about?username=mskarthi95',
  'https://www.freecodecamp.com/api/users/about?username=balajivijay',
  'https://www.freecodecamp.com/api/users/about?username=gandhimathikgcas',
  'https://www.freecodecamp.com/api/users/about?username=vidhya13',
  'https://www.freecodecamp.com/api/users/about?username=gokilavanig',
  'https://www.freecodecamp.com/api/users/about?username=remojohnsonrj',
  'https://www.freecodecamp.com/api/users/about?username=jensikgcas',
  'https://www.freecodecamp.com/api/users/about?username=vinodhithan',
  'https://www.freecodecamp.com/api/users/about?username=hariharanarumugam',
  'https://www.freecodecamp.com/api/users/about?username=dtdheena',
  'https://www.freecodecamp.com/api/users/about?username=81balkis',
  'https://www.freecodecamp.com/api/users/about?username=saranyaammu',
  'https://www.freecodecamp.com/api/users/about?username=saravanan111',
  'https://www.freecodecamp.com/api/users/about?username=dk12dk',
  'https://www.freecodecamp.com/api/users/about?username=mskarthi',
  'https://www.freecodecamp.com/api/users/about?username=pravinbalaji',
  'https://www.freecodecamp.com/api/users/about?username=jagdishranjith',
  'https://www.freecodecamp.com/api/users/about?username=aishwarya2010',
  'https://www.freecodecamp.com/api/users/about?username=vasanthvijay',
  'https://www.freecodecamp.com/api/users/about?username=santhoshnv'
);
$r = multiRequest($data);
 
echo '<pre>';
print_r($r);
?>
