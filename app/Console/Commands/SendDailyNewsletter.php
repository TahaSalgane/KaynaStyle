<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\NewsletterSubscriber;
use App\Mail\NewProductsNewsletter;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily newsletter to subscribers if there are new products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get products created in the last 24 hours
        $newProducts = Product::where('is_active', true)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->with(['colorImages', 'defaultColor'])
            ->get()
            ->map(function ($product) {
                $imagePath = $product->main_image;
                return [
                    'name' => $product->name_en,
                    'price' => $product->sale_price ?? $product->price,
                    'image' => $imagePath ? config('app.url') . '/storage/' . $imagePath : null,
                    'url' => config('app.url') . '/products/' . $product->slug,
                ];
            })
            ->filter(function ($product) {
                return $product['image'] !== null;
            })
            ->values();

        // If no new products, don't send emails
        if ($newProducts->isEmpty()) {
            $this->info('No new products found. Newsletter not sent.');
            return 0;
        }

        // Get all active subscribers
        $subscribers = NewsletterSubscriber::where('is_active', true)->get();

        if ($subscribers->isEmpty()) {
            $this->info('No active subscribers found.');
            return 0;
        }

        $this->info("Found {$newProducts->count()} new product(s). Sending newsletter to {$subscribers->count()} subscriber(s)...");

        $sent = 0;
        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewProductsNewsletter($newProducts, $subscriber->email));
                $sent++;
            } catch (\Exception $e) {
                $this->error("Failed to send email to {$subscriber->email}: " . $e->getMessage());
            }
        }

        $this->info("Newsletter sent successfully to {$sent} subscriber(s).");
        return 0;
    }
}
