<?php
 
//--------------------------------------------------------------------------------------------------------------------------------------------
// d2aApi.php
// (c) 2021 Simbel ECommerce 
//--------------------------------------------------------------------------------------------------------------------------------------------
// 22-06-20	1.0  GDS
//--------------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------------
// Class definition
//--------------------------------------------------------------------------------------------------------------------------------------------

class d2aApiTrk {
    
   public $cs; 
   public $abuVer; 
   public $ts;
   public $tz; 
   public $sessionName; 
   public $visitorName; 
   public $registrant; 
   public $operation; 
   public $ApiKey; 
   public $hs;
   public $ip;
    

   function __construct($ApiKey,$ApiSecret,$cs,$sessionName,$visitorName,$registrant,$operation,$hs="",$ip="",$ts="",$tz="") {
    $this->cs = $cs;
    $this->abuVer = "APIV1.1";
    $this->cs = $cs;
	$this->ts = $ts;
	$this->tz = $tz;
	$this->sessionName = $sessionName;
	$this->visitorName = $visitorName;
	$this->registrant = $registrant;
	$this->operation = $operation;
	$this->ApiKey = $ApiKey;
	$this->hs = $hs;
	$this->ip = $ip;
    }
    
}

class d2aAIget {
    
   public $track;
   public $modelType;
   public $model;
   public $dataIn;
   public $fallback;
   public $noRepeat;
   public $limit;
   public $offerName;
   public $pageName;
   public $data;

    
    function __construct($modelType,$model,$dataIn,$fallback="",$noRepeat="",$limit=0,$offerName="",$pageName="") {
	$this->track="";
	$this->modelType = $modelType;
	$this->model = $model;
	$this->dataIn = $dataIn;
	$this->fallback = $fallback;
	$this->noRepeat = $noRepeat;
	$this->limit = $limit;
	$this->offerName = d2aTextEncoding($offerName);
	$this->pageName = d2aTextEncoding($pageName);
	$this->data = "";
    }
}


class d2aPaymentMethod {
    
   public $name;
   public $currency;
   public $originalAmount;
   public $financedAmount;
   public $installments;
    
    
    function __construct($name,$currency,$originalAmount,$financedAmount=0,$installments=0) {
    $this->name = d2aTextEncoding($name);
	$this->currency = $currency;
	$this->originalAmount = $originalAmount;
	$this->financedAmount = $financedAmount;
	$this->installments = $installments;
    }
}

class d2aPrice {
    
    public $currency;
    public $amount;
    public $totalAmount;
    
    function __construct($currency,$amount,$totalAmount="") {
	$this->currency = $currency;
	$this->amount = $amount;
	$this->totalAmount = $totalAmount;
    }

}

class d2aDelivery {
    
    public $courier;
    public $branch;
    public $pickupPoint;
    public $price;
    public $zone;
    public $place;
    public $zip;

    function __construct($courier,$branch,$pickupPoint,$price,$zone,$place,$zip) {
    $this->courier = d2aTextEncoding($courier);
    $this->branch = d2aTextEncoding($branch);
    $this->pickupPoint = d2aTextEncoding($pickupPoint);
	$this->price = $price;
	$this->zone = d2aTextEncoding($zone);
	$this->place = d2aTextEncoding($place);
	$this->zip = $zip;
    }

}

class d2aUnit {
    
    public $items;
    public $price;

    function __construct($items,$price) {
	$this->items = $items;
	$this->price = $price;
    }

}

class d2aProduct {
    
    public $productName;
    public $productCategoryName;
    public $sku;
    public $units;
    public $loyaltyPointsValue;
    public $loyaltyPointsUsed;
    
    function __construct($productName,$productCategoryName,$units,$sku="",$loyaltyPointsValue="",$loyaltyPointsUsed="") {
        $this->productName = d2aTextEncoding($productName);
        $this->productCategoryName = d2aTextEncoding($productCategoryName);
		$this->sku = $sku;
		$this->units = $units;
		$this->loyaltyPointsValue = $loyaltyPointsValue;
		$this->loyaltyPointsUsed = $loyaltyPointsUsed;
	}
}
 

class d2aUpdateCart {
    
    public $track;
    public $cartName;
    public $orderName;
    public $cartStatus;
    public $totalItems;
    public $price;
    public $paymentMethod;
    public $loyaltyPointsValue;
    public $loyaltyPointsUsed;

    
    function __construct($cartName,$orderName,$cartStatus,$totalItems="",$arrayOfPrice="",$arrayOfPaymentMethod="",$loyaltyPointsValue="",$loyaltyPointsUsed="") {
    	$this->track = "";
    	$this->cartName = $cartName;
    	$this->orderName = $orderName;
    	$this->cartStatus = $cartStatus;
    	$this->totalItems = $totalItems;
    	$this->price = $arrayOfPrice;
    	$this->paymentMethod = $arrayOfPaymentMethod;
    	$this->loyaltyPointsValue = $loyaltyPointsValue;
    	$this->loyaltyPointsUsed = $loyaltyPointsUsed;
    }
  
}

class d2aOrder { 
    
    public $track;
    public $cartName;
    public $orderName;
    public $cartStatus;
    public $aProducts;
    public $totalItems;
    public $price;
    public $paymentMethod;
    public $delivery;
    public $loyaltyPointsValue;
    public $loyaltyPointsUsed;
    
    function __construct($cartName,$orderName,$cartStatus,$arrayOfProducts,$totalItems,$arrayOfPrice,
                         $arrayOfPaymentMethod,$delivery="",$loyaltyPointsValue="",$loyaltyPointsUsed="") {
    	$this->track = "";
    	$this->cartName = $cartName;
    	$this->orderName = $orderName;
    	$this->cartStatus = $cartStatus;
    	$this->aProducts = $arrayOfProducts;
    	$this->totalItems = $totalItems;
    	$this->price = $arrayOfPrice;
    	$this->paymentMethod = $arrayOfPaymentMethod;
    	$this->delivery = $delivery;
    	$this->loyaltyPointsValue = $loyaltyPointsValue;
    	$this->loyaltyPointsUsed = $loyaltyPointsUsed;
    }
  
}


class d2aPageView {
    
    public $track;
    public $pageName;
    public $pageCategoryName;
    public $ge;
    
    function __construct($pageName,$pageCategoryName,$ge) {
            $this->track = "";
            $this->pageName = d2aTextEncoding($pageName);
            $this->pageCategoryName = d2aTextEncoding($pageCategoryName);
            $this->ge = $ge;
    }
    
}



class d2aProductView {
    
    public $track;
    public $productName;
    public $productCategoryName;
    public $sku;
    
    function __construct($productName,$productCategoryName,$sku="") {
        $this->track = "";
        $this->productName = d2aTextEncoding($productName);
        $this->productCategoryName = d2aTextEncoding($productCategoryName);
        $this->sku = $sku;
    }
    
}




class d2aRegistration {
    
    public $track;
    public $registrant;
    public $typeOfId;
    public $nationalId;
    public $name;
    public $lastName;
    public $gender;
    public $age;
    public $email;
    public $cellphone;
    public $facebookId;
    public $instagramId; 
    public $twitterId; 
    public $linkedinId; 
    public $city;
    public $state;
    public $country;
    public $address1;
    public $address2;
    public $companyName;
    public $companyCustomer;
    
    
    function __construct($registrantId,$typeOfId,$nationalId,$name,$lastName,$gender,$age,$email,$cellphone,$facebookId,$instagramId,$twitterId,
                         $linkedinId,$city,$state,$country,$address1,$address2,$companyName,$companyCustomer) {
        $this->track =  "";
        $this->registrant = $registrantId;
        $this->typeOfId = $typeOfId;
        $this->nationalId = $nationalId;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->age = $age;
        $this->email = $email;
        $this->cellphone = $cellphone;
        $this->facebookId = $facebookId;
        $this->instagramId = $instagramId;
        $this->twitterId = $twitterId;
        $this->linkedinId = $linkedinId;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->companyName = $companyName;
        $this->companyCustomer = $companyCustomer;
    }
    
}


class d2aMsg {
    
    public $track;
    public $ms;

    function __construct($ApiKey,$ApiSecret,$cs,$rg,$op,$hs,$ms) {
	$this->track = new d2aApiTrk($ApiKey,$ApiSecret,$cs,$rg,$op,$hs);
	$this->ms = $ms;
    }

}


class d2a {
    
    public $ApiKey;
    public $ApiSecret;
    public $rs;
    public $cs;
    public $sn;
    public $vn;
    public $ts;
    public $tz;
    public $rg;
    public $op;
    public $rc;
    public $ec;
    public $me;
    public $hs;
    public $st;
    public $ms;
    public $ip;
    public $data;
    
    function __construct($ApiKey,$ApiSecret,$rs,$cs,$sn="",$vn="",$rg="",$op="",$ms="",$ip="",$ts="",$tz="") {
	$this->ApiKey = $ApiKey; 		// mandatory
	$this->ApiSecret = $ApiSecret;  // mandatory
	$this->rs = $rs;       // mandatory
	$this->cs = $cs;       // mandatory
	$this->sn = $sn;
	$this->vn = $vn;
	$this->ts = $ts;
	$this->tz = $tz;
	$this->rg = $rg;
	$this->op = $op;		// optional
	$this->rc = "";			// return code
	$this->ec = "";			// error code
	$this->me = "";			// d2a message unique id
	$this->hs = "";			// hash code
	$this->st = "";			// string to hash
	$this->ms = $ms;		// message
	$this->ip = $ip;		// ip caller
	$this->data ="";
    }
    
    public function set($op){
    	$this->st = $this->ApiKey . $this->ApiSecret . $this->cs . $this->rg . $op;
    	$this->hs = md5($this->st);
    }
    
    public function  getLastMessageStatus(){
	   return([$this->me,$this->rc,$this->ec,$this->sn,$this->vn,$this->rc]);
    }
    
    public function getData(){
	   return($this->data);
    }
    
    public function  message($op,$message){
        $this->set($op);
        $this->ms = $message;
        $this->ms->track = new d2aApiTrk($this->ApiKey,$this->ApiSecret,$this->cs,$this->sn,$this->vn,$this->rg,$op,$this->hs,$this->ip,$this->ts,$this->tz);
    }
    
    
    public function send(&$con){
        
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "d2a API", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        );
        
       
        // what post fields?
        $fields = array(
            'data' => json_encode($this->ms)
        );
        
        // build the urlencoded data
        $postvars = http_build_query($fields);
        
        // open connection
        $ch = curl_init();
        
        curl_setopt_array($ch, $options);
        
        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, "https://" . $this->rs . "/Dashboard/Loader/api");
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        
        // execute post
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        echo "🔍 **Debug de la respuesta:**\n";
        echo "HTTP Code: $httpCode\n";
        echo "cURL Error: $error\n";
        echo "Response: $response\n\n";
        
        if ($error) {
            echo "❌ Error de cURL: $error\n";
            return;
        }
        
        if (!$response) {
            echo "❌ No se recibió respuesta\n";
            return;
        }
        
        $result = json_decode($response);
        
        if (!$result) {
            echo "❌ Error al decodificar JSON: " . json_last_error_msg() . "\n";
            return;
        }
        
        if (!isset($result->track)) {
            echo "❌ Respuesta no tiene estructura 'track': " . print_r($result, true) . "\n";
            return;
        }
          
        $con->rc = $result->track->rc;
        $con->ec = $result->track->ec;
        $con->me = $result->track->mi;
        $con->ip = $result->track->ip;
        $con->ts = $result->track->ts;
        $con->sn = $result->track->sessionName;
        $con->vn = $result->track->visitorName;
        $con->rc = $result->track->registrant;
        if (property_exists($result, 'data')) $con->data = $result->data;
        
        // close connection
        curl_close($ch); 
    }
    
}

//--------------------------------------------------------------------------------------------------------------------------------------------	
//Encoding utf8
//--------------------------------------------------------------------------------------------------------------------------------------------	
function d2aTextEncoding($string){
    $aux = mb_convert_encoding($string, 'UTF-8', mb_list_encodings());
	return($aux);
} 

?> 