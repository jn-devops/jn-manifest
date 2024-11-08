<?php

namespace App\Notifications;

use LBHurtado\EngageSpark\Notifications\Adhoc as BaseAdhoc;

class ForRevisionNotification extends BaseAdhoc
{
    public function __construct()
    {
        $message = 'For Revision';

        parent::__construct($message);
    }
}

