<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PruneDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:prune-deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete accounts that have been pending for more than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('deletion_requested_at', '<=', now()->subHours(24))->get();

        $count = $users->count();
        
        foreach ($users as $user) {
            // Delete profile photos if they exist
            if ($user->profile) {
                for ($i = 1; $i <= 3; $i++) {
                    $photoField = "photo{$i}";
                    if ($user->profile->$photoField) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile->$photoField);
                    }
                }
                $user->profile->delete();
            }
            
            // Delete interests and likes
            \App\Models\Interest::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->delete();
            \App\Models\Like::where('user_id', $user->id)->orWhere('liked_user_id', $user->id)->delete();
            
            $user->delete();
        }

        $this->info("Successfully pruned {$count} deleted accounts.");
    }
}
