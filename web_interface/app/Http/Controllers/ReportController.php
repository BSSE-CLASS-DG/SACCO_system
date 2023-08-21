<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\available_deposits;
use App\Models\Member; // Assuming the Member model is in the 'App\Models' namespace

class ReportController extends Controller
{
   
public function sendEmailsWithAttachment(Request $request)
{
  // Validate the request here if needed

$pdfFile = $request->file('pdf_file');

// Check if a file was uploaded
if ($pdfFile) {
    // Upload the PDF file to a temporary location
    $pdfPath = $pdfFile->storeAs('temp_pdfs', 'report.pdf');

    // Retrieve the list of member numbers who have deposited in the last six months
    $memberNumbers = available_deposits::whereBetween('deposit_date', [now()->subMonths(6), now()])
        ->groupBy('member_number') // Assuming you have a column named 'member_number'
        ->pluck('member_number');

    // Retrieve the email addresses of members who have deposited
    $emails = Member::whereIn('member_number', $memberNumbers)
        ->pluck('email');

    if ($emails->count() > 0) {
        // Loop through email addresses and send emails
        foreach ($emails as $email) {
            Mail::send('pages.report', [], function ($message) use ($email, $pdfPath) {
                $message->to($email)
                    ->subject('Monthly Report')
                    ->attach(storage_path('app/' . $pdfPath));
            });
        }

        // Delete the temporary PDF file after sending emails
        Storage::delete($pdfPath);

        return redirect()->back()->with('success', 'Emails sent successfully.');
    } else {
        return redirect()->back()->with('error', 'No active member found.');
    }
}

// If no file was uploaded, return with an error message
return redirect()->back()->with('error', 'No file uploaded.');

}

}


