<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebhookController extends Controller
{
    /**
     * Handle incoming GitHub webhook
     */
    public function handle(Request $request): JsonResponse
    {
        // Verify GitHub webhook signature
        $signature = $request->header('X-Hub-Signature-256');
        $payload = $request->getContent();

        if (!$this->verifyWebhookSignature($payload, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);

        // Handle push events only
        if ($request->header('X-GitHub-Event') === 'push') {
            return $this->handlePushEvent($data);
        }

        // Handle pull request events
        if ($request->header('X-GitHub-Event') === 'pull_request') {
            return $this->handlePullRequestEvent($data);
        }

        return response()->json(['status' => 'received'], 200);
    }

    /**
     * Handle push events from GitHub
     */
    private function handlePushEvent(array $data): JsonResponse
    {
        $branch = str_replace('refs/heads/', '', $data['ref'] ?? '');
        $repository = $data['repository']['name'] ?? 'unknown';
        $pusher = $data['pusher']['name'] ?? 'unknown';
        $commits = $data['commits'] ?? [];

        // Only process main branch pushes
        if ($branch !== 'main') {
            return response()->json([
                'status' => 'ignored',
                'message' => "Branch '{$branch}' is not main"
            ], 200);
        }

        \Log::info('GitHub webhook received', [
            'event' => 'push',
            'repository' => $repository,
            'branch' => $branch,
            'pusher' => $pusher,
            'commits_count' => count($commits),
            'timestamp' => now(),
        ]);

        // Log commit details
        foreach ($commits as $commit) {
            \Log::info('Commit pushed', [
                'id' => $commit['id'],
                'message' => $commit['message'],
                'author' => $commit['author']['name'] ?? 'unknown',
                'timestamp' => $commit['timestamp'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Received {$branch} branch push from {$pusher}",
            'commits' => count($commits),
        ], 200);
    }

    /**
     * Handle pull request events from GitHub
     */
    private function handlePullRequestEvent(array $data): JsonResponse
    {
        $action = $data['action'] ?? 'unknown';
        $pr = $data['pull_request'] ?? [];
        $repository = $data['repository']['name'] ?? 'unknown';
        $prNumber = $pr['number'] ?? 'unknown';
        $prTitle = $pr['title'] ?? 'unknown';
        $prAuthor = $pr['user']['login'] ?? 'unknown';

        \Log::info('GitHub webhook received', [
            'event' => 'pull_request',
            'action' => $action,
            'repository' => $repository,
            'pr_number' => $prNumber,
            'pr_title' => $prTitle,
            'author' => $prAuthor,
            'timestamp' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "PR #{$prNumber} {$action}: {$prTitle}",
            'pr_author' => $prAuthor,
        ], 200);
    }

    /**
     * Verify webhook signature from GitHub
     */
    private function verifyWebhookSignature(string $payload, ?string $signature): bool
    {
        // Get webhook secret from environment
        $secret = config('services.github.webhook_secret');

        // If no secret configured, log warning but allow for testing
        if (!$secret) {
            \Log::warning('GitHub webhook secret not configured in .env');
            return true; // Allow unsigned webhooks in development
        }

        // GitHub uses HMAC-SHA256
        if (!$signature || !str_starts_with($signature, 'sha256=')) {
            return false;
        }

        $expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        // Use hash_equals to prevent timing attacks
        return hash_equals($expected, $signature);
    }
}
