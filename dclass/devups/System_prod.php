<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use dclass\devups\Controller\Controller;

/**
 * Description of System_prod
 *
 * @author aurelien.ATEMKENG
 */
class System_prod  extends Controller{
    //put your code here
    
        public static function LANG(){
            return ["fr", 'en'];
        }

        
        public static function _PARSEURL($str, $charset='utf-8')
        {
            $str = htmlentities($str, ENT_NOQUOTES, $charset);

            $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
            $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
            $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
            $str = str_replace(' ', '_', $str); // supprime les autres caractères

            return strtolower($str);
        }

        public function sendMail($user_email, $name, $system_email, $subject, $message, $telephone = null) {
                header('Content-type: application/json');
                $status = array(
                        'type'=>'success',
                        'message'=>'Thank you for contact us. As early as possible  we will contact you '
                );

                $body="Bonjour <br>".  $name;
                $body.="<br/>\r\n";

                if($telephone)
                    $body.="<br/>\r\n".'TEL'.  $telephone;

                $body.="<br/>\r\n".  $message;

                 //On construit les headers
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                // En-têtes additionnels
                $headers .= 'Reply-To: '.$system_email."\n"; // Mail de reponse
                $headers .= 'To: '.$name.' <'.$user_email.'>' . "\r\n";
                $headers .= 'From: LITTLESHOPP <'.$system_email.'>' . "\r\n";
                $headers .= 'Delivered-to: '.$user_email."\n"; // Destinataire

                $status = mail($user_email, $subject, $body, $headers);

    //            $email_from = $email;
    //            $email_to = 'email@email.com';//replace with your email
    //
    //            $body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;
    //
    //            $success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');

                return $status;
        }
        
        public function smsAPI($destination, $message) {
                //$client = unserialize($_SESSION[CLIENT]);
                $url = 'http://lmtgroup.dyndns.org/sendsms/sendsmsGold.php?';
                $timeout = 10;
                $username='littleshopp';
                $password='I9deEgai';
                //$destination= 694573490;//$client->getTelephone();//'698160168';
                $source='LITTLESHOPP';
                //$message='Texte du SMS';//.$_POST['no_commande'];

                $request  = $url."UserName=".urlencode($username)."&Password=".urlencode($password);
                $request .= "&SOA=".urlencode($source)."&MN=".urlencode($destination)."&SM=".urlencode($message);

                //$url =$request;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $request);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_POST, 1);

                $response = json_decode(curl_exec($ch));
                curl_close($ch);
                //var_dump($response);
                return $response;
        }
        
        public function visaAPI($amount = 0, $ref = "") {
                ///Variables that are required by visa
                /*
                'vpc_Version'=>'1'//constant
                'vpc_Command'=>'pay'//constant
                'vpc_AccessCode'=>'48472047'//Access code which will be changed
                'vpc_MerchTxnRef'=>'33adsfss'///this is your unique reference
                'vpc_Merchant'=>'ECO011'//merchant ID which will be changed when we go live
                'vpc_Amount'=>'100'//Amount in pesewas
                'vpc_Currency'=>'GHS'
                'vpc_Locale'=>'en'//constant
                'vpc_ReturnURL'=>'https://someDomain.com/visaReturn.php'
                'vpc_OrderInfo'=>'VPC Example'//This can be a description of the payment

                */
                $params = array('vpc_Version'=>'1',
                                'vpc_Command'=>'pay',
                                'vpc_AccessCode'=>'5EFC3765',
                                'vpc_MerchTxnRef'=>$ref,
                                'vpc_Merchant'=>'ECMTEST05',
                                'vpc_Amount'=>$amount,
                                'vpc_Currency'=>'GHS',
                                'vpc_Locale'=>'en',
                                'vpc_ReturnURL'=>'https://www.littleshopp.com/callbackvisa',
                                'vpc_OrderInfo'=>$ref);

                ksort($params,SORT_NATURAL);
                $secretHash = "54890DBA72A3D3BB186A1EEFCEE7CF67";
                $dataHash = implode('',$params);

                $secureHash = strtoupper(md5($secretHash.$dataHash));


                $paraFinale = array_merge($params,array('vpc_SecureHash'=>$secureHash));

                //header("Location:https://migs-mtf.mastercard.com.au/vpcpay?".http_build_query($paraFinale));
                return "https://migs-mtf.mastercard.com.au/vpcpay?".http_build_query($paraFinale);
                 
        }

    public function _edit($id) {
        
    }

    public function _new() {
        
    }

    public function listView($next = 1, $per_page = 10)
    {
        // TODO: Implement listView() method.
    }
}
