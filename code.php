public function enviarMail( $objMail=null)
    //Envio de mail por usuario, pero sin auth de google
    {
        //ENVIO DE MAILS
        $mail = new LATCOMSender();

        //El que envia /Ejecutivo
        $mail->From = $objMail->fromMail; //'crastelli@tolber.io';
        $mail->Username= $objMail->fromMail; //'crastelli861W';
        $mail->FromName = $objMail->fromName; // 'Cesar Rastelli';
        $mail->Password= $objMail->fromPassword; //'crastelli861W';
        
        $mail->Subject = $titulo = $objMail->motivo;
        
        $content = $objMail->texto;       
        //Al que se le envia /El Contacto
        $mail->AddAddress($objMail->mail); 

        //Para las copias a enviar
        $arr_mails=explode(';', $objMail->mails);
        for ($i=0; $i < count($arr_mails) ; $i++) {
            $mail->AddCC($arr_mails[$i]);
        }

        foreach ($objMail->files as $file) {
            $mail->AddAttachment($file['path'], $file['name']);
        }
        
        //ReplyTo
        $mail->AddReplyTo($objMail->fromMail); 

        $mail->Body    =  utf8_decode($content);
   
        return $mail->enviar();//DESCOMENTAR    

    }
