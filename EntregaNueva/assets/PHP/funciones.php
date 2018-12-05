<?php 
function AddMessage($id1, $id2, $m)
{

    $curl = curl_init();
    $stri = "http://rapanui28.ing.puc.cl/add_message?1=$id1&2=$id2&m=".preg_replace("/[\s]/", "%20", $m);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $stri,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    return $response;
}


function GetUser($id)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://rapanui28.ing.puc.cl/user/$id",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    return $response;
}

function GetMesByText($id, $si, $talv, $no)
{
    $curl = curl_init();
    $preg = "http://rapanui28.ing.puc.cl/search?id=$id&1=".join('|', $si)."&2=".join('|', $talv)."&3=".join('|', $no);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $preg,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    return $response;
}
?>