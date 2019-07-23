<?php

namespace App\Reminder;

interface ReminderInterface
{
    public function handle(): void;
    public function willSend(): bool;
    public function getAdminsEmails(): array;
    public function buildEmail(): ReminderInterface;
    public function sendEmails(array $emails, ReminderInterface $reminder): void;
}
