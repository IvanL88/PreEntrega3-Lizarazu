<?php


public function enviarPorUsuario($debugEmail = NULL) {        
        $this->isSMTP();
        $this->isHTML(TRUE);
        if ($debugEmail) {
            $this->clearAddresses();
            $this->clearAllRecipients();
            $this->clearBCCs();
            $this->clearCCs();
            $this->addAddress($debugEmail);
            $this->From = $debugEmail;
            $this->addReplyTo($debugEmail);
            $this->SMTPDebug = 3;
            $this->send(TRUE);
            echo '<pre>';
            print_r($this);
            exit;
            return $this->send(TRUE);
        }
        try{             
            if ((!is_null($this->TokenSender)) && ($this->TokenSender!='')){      
                $provider = new Google([
                    "clientId" => $this->clientId,
                    "clientSecret" => $this->clientSecret,
                ]);      
                $this->setOAuth(
                    new PHPMailer\PHPMailer\OAuth([
                        "provider"      => $provider,
                        "clientId"      => $this->clientId,
                        "clientSecret"  => $this->clientSecret,
                        "refreshToken"  => $this->TokenSender,
                        "userName"      => $this->Username,
                    ])
                );     
            }
            return $this->send(TRUE);
        }catch (Exception $e) {
            log_message('error', $e->getMessage()); 
            return false;
        }
    }   


?>
