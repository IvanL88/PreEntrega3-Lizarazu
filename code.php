<?php


public function enviarMailPorUsuario($objMail=null)
    //Envio de mail por usuario
    { 
        //ENVIO DE MAILS
        $mail = new LATCOMSender();     
        $mail->CharSet      = "UTF-8"; //El conjunto de caracteres del mensaje.

        //El que envia /Ejecutivo
        $mail->From         = $objMail->fromMail; //La dirección de correo electrónico del remitente del mensaje.
        $mail->FromName     = $objMail->fromName; //El nombre de del mensaje.
        if (isset($objMail->fromSenderToken) && $objMail->fromSenderToken!=''){
            $mail->AuthType     = "XOAUTH2"; //Tipo de autenticación SMTP.
            $mail->TokenSender  = $objMail->fromSenderToken; // Token Sender
        }else{
            $mail->Password = $objMail->fromPassword; //Contraseña
        }
        $mail->Username     = $objMail->fromMail; //Nombre de usuario
        $mail->Subject      = $titulo = $objMail->motivo; //Asunto 
        
        $content = $objMail->texto;    
        
        $mail->AddAddress($objMail->mail); //Al que se le envia /El Contacto
        //Para las copias a enviar       
        if(isset($objMail->mails) && count($objMail->mails) > 0 )
        {
            $arr_mails=explode(';', $objMail->mails);
            for ($i=0; $i < count($arr_mails) ; $i++) {
                $mail->AddCC($arr_mails[$i]);
            }
        }
        if(isset($objMail->files))
        {
            foreach ($objMail->files as $file) {
                $mail->AddAttachment($file['path'], $file['name']);
            }               
        }
        $mail->AddReplyTo($objMail->fromMail); //RespoderA    
        $mail->Body    =  utf8_decode($content); //Cuerpo      
        try{
            return $mail->enviarPorUsuario(); 
        }catch (Exception $e) {
            echo "Excepción capturada: ", $e->getMessage(), "\n";
            log_message('error', 'error'); 
            return false;
        }   
    } 




?>
