<?php


namespace Application\Service\Notify;


class PhpMailNotify implements NotifyInterface
{

    /**
     * @param string $address
     * @param string $subject
     * @param string $message
     */
    public function notify($address, $subject, $message)
    {
        ini_alter('SMTP', '127.0.0.1');
        ini_alter('smtp_port', 1025);
        ini_alter('sendmail_from', 'refusebot@hackathon.local');
        ini_alter('mail.force_extra_parameters', '-f refusebot@hackathon.local');
        mail($address, $subject, $message, null, '-frefusebot@hackathon.local');
    }
}