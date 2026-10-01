<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Optional: Verify secret signature from GitHub header
        $signature = $request->header('X-Hub-Signature-256');
        $secret = config('services.github.webhook_secret'); // Store in .env as GITHUB_WEBHOOK_SECRET

        if ($secret && $signature) {
            $knownSignature = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);
            if (!hash_equals($knownSignature, $signature)) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        // Log or process the webhook event payload
        $event = $request->header('X-GitHub-Event');
        Log::info("GitHub Webhook received event: {$event}");

        // Example: Trigger deployment/git pull on Hostinger (if needed)
        if ($event === 'push') {
            Log::info('Push event received from GitHub', [
                'branch' => $request->input('ref'),
                'repository' => $request->input('repository.name'),
                'pusher' => $request->input('pusher.name'),
            ]);
            // Execute deployment commands or dispatch a job here
        }

        return response()->json(['status' => 'success'], 200);
    }
}
