<?php
namespace App\Mail;
use App\Models\PriceAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class PriceAlertTriggered extends Mailable
{
use Queueable, SerializesModels;
public function __construct(
public PriceAlert $alert
) {
}
public function envelope(): Envelope
{
return new Envelope(
subject: 'Alerta de cotação atingido - ' .
$this->alert->asset->name,
);
}
public function content(): Content
{
return new Content(
view: 'emails.price-alert-triggered',
);
}
}