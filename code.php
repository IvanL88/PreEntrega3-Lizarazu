<?php



  public function enviarMailPorAuth($objMail=null)
    //Envio de mail por usuario, pero con auth de google
    { 
        //ENVIO DE MAILS
        $mail = new LATCOMSender();

        $mail->AuthType     = "XOAUTH2"; //Tipo de autenticación SMTP.
        $mail->CharSet      = "UTF-8"; //El conjunto de caracteres del mensaje.       
        $mail->From         = $objMail->fromMail; //La dirección de correo electrónico del remitente del mensaje.
        $mail->FromName     = $objMail->fromName; //El nombre de del mensaje.
        $mail->TokenSender  = $objMail->fromSenderToken; // Token Sender
        $mail->Username     = $objMail->fromMail; //Nombre de usuario
        $mail->Subject      = $titulo = $objMail->motivo; //Asunto 
        
        $content = $objMail->texto;         
        
        $mail->AddAddress($objMail->mail); //Al que se le envia /El Contacto

        //Para las copias a enviar
        $arr_mails=explode(';', $objMail->mails);
        for ($i=0; $i < count($arr_mails) ; $i++) {
            $mail->AddCC($arr_mails[$i]);
        }

        foreach ($objMail->files as $file) {
            $mail->AddAttachment($file['path'], $file['name']);
        }        
       
        $mail->AddReplyTo($objMail->fromMail); //RespoderA    
        $mail->Body    =  utf8_decode($content); //Cuerpo
      
        try{
           return $mail->enviarPorAuth();       
        }catch (Exception $e) {
            echo "Excepción capturada: ", $e->getMessage(), "\n";
            log_message('error', 'error'); 
            return false;
        }       

    } 





?>
