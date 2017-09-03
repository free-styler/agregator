<?php
class NewMail {

    public static function sendMail($from,$to,$subject,$body) {
        include_once(ROOT."/inc/Libmail.php");
        $mailer = new Mail();
        $mailer->From($from);
        $mailer->To($to);
        $mailer->Subject($subject);
        $mailer->Body($body, 'html');
        $mailer->Send();
    }

}