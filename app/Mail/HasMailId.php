<?php

namespace App\Mail;

interface HasMailId
{
    public function getMailId(): string;
}
