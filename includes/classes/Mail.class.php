<?php

/**
 *  2Moons
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class Mail
{
    static public function send($mailTarget, $mailTargetName, $mailSubject, $mailContent)
    {
        $mail = self::getMailObject();

        $mail->CharSet = 'UTF-8';
        $mail->Subject = $mailSubject;
        $mail->Body = $mailContent;
        $mail->AddAddress($mailTarget, $mailTargetName);
        $mail->Send();
    }

    static public function multiSend($mailTargets, $mailSubject, $mailContent = NULL)
    {
        $mail = self::getMailObject();

        $mail->Subject = $mailSubject;

        foreach ($mailTargets as $address => $data) {
            $content = isset($data['body']) ? $data['body'] : $mailContent;

            $mail->AddAddress($address, $data['username']);
            $mail->MsgHTML($content);
            $mail->Send();
            $mail->ClearAddresses();
        }
    }

    static private function getMailObject()
    {
        require_once 'includes/libs/phpmailer/class.phpmailer.php';

        $mail = new PHPMailer(true);
        $mail->PluginDir = 'includes/libs/phpmailer/';

        $config = Config::get();

        if ($config->mail_delivery_type == 'smtp') {
            $mail->IsSMTP();
            $mail->SMTPSecure = $config->mail_smtp_encryption;
            $mail->Host = $config->mail_smtp_host;
            $mail->Port = $config->mail_smtp_port;

            if ($config->mail_smtp_username != '') {
                $mail->SMTPAuth = true;
                $mail->Username = $config->mail_smtp_username;
                $mail->Password = $config->mail_smtp_password;
            }
        } else {
            throw new Exception("sendmail is deprecated, use SMTP instead!");
        }

        $mailFromAddress = $config->mail_sender;
        $mailFromName = $config->game_name;
        $mail->Timeout = 15;
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom($mailFromAddress, $mailFromName);

        return $mail;
    }
}