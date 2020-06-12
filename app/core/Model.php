<?php

namespace Core;

use Illuminate\Database\Capsule\Manager as Capsule;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

abstract class Model
{
    public $db;
    public $mailer;

    public function __construct() {
        $config = require 'app/config/db.php';
        $mail_config = require 'app/config/mail.php';

        $this->mailer = new PHPMailer(true);
        if (DEBUG) {
            $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        }
        $this->mailer->isSMTP();                                            // Send using SMTP
        
        $this->mailer->Host       = $mail_config['host'];                    // Set the SMTP server to send through
        $this->mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->mailer->Username   = $mail_config['username'];                     // SMTP username
        $this->mailer->Password   = $mail_config['password'];                               // SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mailer->Port       = $mail_config['port'];
        $this->mailer->setFrom($mail_config['from_address'], $mail_config['from_name']);


        $capsule = new Capsule;
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
    }
}