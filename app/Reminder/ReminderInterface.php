<?php

namespace App\Reminder;

interface ReminderInterface
{
    public function handle(): void;
    public function setReminder(int $day): void;
    public function willSend($day): bool;
    public function getAdminsEmails(): array;
    public function sendEmails(array $emails, ReminderInterface $reminder): void;
}
