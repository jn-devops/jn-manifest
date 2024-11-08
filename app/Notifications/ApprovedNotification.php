<?php

namespace App\Notifications;

use LBHurtado\EngageSpark\Notifications\Adhoc as BaseAdhoc;

class ApprovedNotification extends BaseAdhoc
{
    public function __construct()
    {
        $message = 'Approved';

        parent::__construct($message);
    }
}

