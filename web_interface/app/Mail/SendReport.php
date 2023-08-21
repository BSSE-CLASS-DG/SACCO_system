<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfFileName;

    public function __construct($pdfFileName)
    {
        $this->pdfFileName = $pdfFileName;
    }

    public function build()
    {
        return $this->subject('Monthly Report')->view('emails.report')
            ->attach(storage_path('app/public/' . $this->pdfFileName), [
                'as' => 'report.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
