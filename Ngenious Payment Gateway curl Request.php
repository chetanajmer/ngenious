<?php  


      $apikey = "Your API KEY";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,'https://api-gateway.sandbox.ngenius-payments.com/identity/auth/access-token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "accept: application/vnd.ni-identity.v1+json",
        "authorization: Basic " . $apikey,
        "content-type: application/vnd.ni-identity.v1+json",

      ));
      curl_setopt($ch, CURLOPT_VERBOSE, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"realmName1\":\"ni\"}");
      $result = curl_exec($ch);

      //print_r($result);die;
      if ($result) {
        $output = json_decode($result);
        $token= $output->access_token;
      } else {
        dd(curl_getinfo($ch));
      }



        //order
        
        
      $amount=200; 
      $customerEmailAddress="Email Address";
      $orderId="300245";
      $postData = new StdClass();
      $postData->action = "SALE";
      $postData->amount = new StdClass();
      $postData->amount->currencyCode = "AED";
      $postData->amount->value = $amount * 100;
      $postData->emailAddress = $customerEmailAddress;

      $postData->merchantAttributes = new StdClass();
      $postData->merchantAttributes->merchantOrderReference = $orderId;
      $postData->merchantAttributes->redirectUrl ='yourdomain/thank-you';
      $postData->merchantAttributes->cancelUrl ='yourdomain/thank-you';
      //if (!empty($billingAddress)) {
        $postData->billingAddress = new StdClass();
        $postData->billingAddress->firstName = ""; //$billingAddress['firstName'];
        $postData->billingAddress->lastName = "";//$additional['billingAddress']['lastName'];
        $postData->billingAddress->address1 = "";//$additional['billingAddress']['address1'];
        $postData->billingAddress->city = "";//$additional['billingAddress']['city'];
        $postData->billingAddress->countryCode =""; ///$additional['billingAddress']['countryCode'];
     // }
      if (!empty($additional['shippingAddress'])) {
        $postData->shippingAddress = new StdClass();
        $postData->shippingAddress->firstName ='Chetan';
        $postData->shippingAddress->lastName ='Chetan';
        $postData->shippingAddress->address1 ='Chetan';
        $postData->shippingAddress->city ='Chetan';
        $postData->shippingAddress->countryCode ='AED';
      }
      if (!empty($additional['merchantDefinedData'])) {
        $postData->merchantDefinedData = new StdClass();
        foreach ($additional['merchantDefinedData'] as $key => $value) {
          $postData->merchantDefinedData->$key = $value;
        }
      }

      $outlet = "your outlet id";
      //$token = niPaymentAccessToken();
      $json = json_encode($postData);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,'https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/your outlet id/orders');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $token,
        "Content-Type: application/vnd.ni-payment.v2+json",
        "Accept: application/vnd.ni-payment.v2+json"));
      curl_setopt($ch, CURLOPT_VERBOSE, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      $result = curl_exec($ch);
      if ($result) {
        curl_close($ch);
        $output = json_decode($result);

       echo "<pre>";print_r($output);die;
      }



?>