<?php
namespace Flutterwave;

//uncomment if you need this
//define("BASEPATH", 1);//Allow direct access to rave.php and raveEventHandler.php

require_once('rave.php');
require_once('raveEventHandlerInterface.php');

use Flutterwave\Rave;
use Flutterwave\EventHandlerInterface;

class tkEventHandler implements EventHandlerInterface{
    /**
     * This is called only when a transaction is successful
     * */
    function onSuccessful($transactionData){
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Comfirm that the transaction is successful
        // Confirm that the chargecode is 00 or 0
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here
        if($transactionData["data"]["chargecode"] === '00' || $transactionData["data"]["chargecode"] === '0'){
          echo "Transaction Completed";
      }else{
          $this->onFailure($transactionData);
      }
    }
    
    /**
     * This is called only when a transaction failed
     * */
    function onFailure($transactionData){
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here
       
    }
    
    /**
     * This is called when a transaction is requeryed from the payment gateway
     * */
    function onRequery($transactionReference){
        // Do something, anything!
    }
    
    /**
     * This is called a transaction requery returns with an error
     * */
    function onRequeryError($requeryResponse){
        // Do something, anything!
    }
    
    /**
     * This is called when a transaction is canceled by the user
     * */
    function onCancel($transactionReference){
        // Do something, anything!
        // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution
       
    }
    
    /**
     * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
     * */
    function onTimeout($transactionReference, $data){
        // Get the transaction from your DB using the transaction reference (txref)
        // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
        // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects
      
    }
}


class TokinizedCharge {
    protected $payment;

    function __construct(){
        $this->payment = new Rave($_ENV['SECRET_KEY']);
    }
    function tokenCharge($array){

        //add tx_ref to the paylaod
        if(!isset($array['tx_ref']) || empty($array['tx_ref'])){
            $array['tx_ref'] = $this->payment->txref;
        }

        if(gettype($array['amount']) !== "integer"){
            return '<div class="alert alert-danger" role="alert"> <b>Error:</b> 
            Amount needs to be an integer.
          </div>'; 
        }

        if(!isset($array['token']) || !isset($array['currency']) || !isset($array['country']) || !isset($array['amount']) || !isset($array['email'])){
            return '<div class="alert alert-danger" role="alert"> <b>Error:</b> 
            Missing Param in the Payload. Please check you payload.
          </div>';
        }
            //set the payment handler 
            $this->payment->eventHandler(new tkEventHandler)
            //set the endpoint for the api call
            ->setEndPoint("v3/tokenized-charges");
            //returns the value from the results
            //you can choose to store the returned value in a variable and validate within this function
            return $this->payment->tokenCharge($array);
          
    }
    

    function updateEmailTiedToToken($data){

        //set the payment handler 
        $this->payment->eventHandler(new tkEventHandler)
        //set the endpoint for the api call
        ->setEndPoint("v2/gpx/tokens/embed_token/update_customer");
        //returns the value from the results
        //you can choose to store the returned value in a variable and validate within this function
        return $this->payment->postURL($data);

    }

    function bulkCharge($data){
            //https://api.ravepay.co/flwv3-pug/getpaidx/api/tokenized/charge_bulk
         //set the payment handler 
         $this->payment->eventHandler(new tkEventHandler)
         //set the endpoint for the api call
         ->setEndPoint("flwv3-pug/getpaidx/api/tokenized/charge_bulk");

         $this->payment->bulkCharges($data);

    }

    function bulkChargeStatus($data)
    {
        //https://api.ravepay.co/flwv3-pug/getpaidx/api/tokenized/charge_bulk
         //set the payment handler 
         $this->payment->eventHandler(new tkEventHandler)
         //set the endpoint for the api call
         ->setEndPoint("flwv3-pug/getpaidx/api/tokenized/charge_bulk");

         $this->payment->bulkCharges($data);
    }

    function verifyTransaction(){
        //verify the charge
        return $this->payment->verifyTransaction($this->payment->txref);//Uncomment this line if you need it
    }

    
       
    
    }

    
?>
