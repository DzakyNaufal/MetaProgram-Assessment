<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'wilberttgr@gmail.com';

        $this->info("Sending test email to: {$email}");

        try {
            Mail::raw('Test Email dari ' . config('app.name') . "\n\nIni adalah test email. Jika Anda menerima email ini, berarti konfigurasi mail sudah benar.", function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test Email - ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from_name'));
            });

            $this->info("✅ Test email sent successfully to {$email}");
            $this->info("Please check your inbox and spam folder.");
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            $this->error("Please check your mail configuration in .env file");
            $this->newLine();
            $this->info("Current mail configuration:");
            $this->table(['Setting', 'Value'], [
                ['MAIL_MAILER', config('mail.mailer')],
                ['MAIL_HOST', config('mail.host')],
                ['MAIL_PORT', config('mail.port')],
                ['MAIL_ENCRYPTION', config('mail.encryption')],
                ['MAIL_FROM_ADDRESS', config('mail.from.address')],
            ]);
        }
    }
}
