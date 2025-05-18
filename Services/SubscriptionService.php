use App\Models\Subscription; // <-- the model
use App\Models\User;

class SubscriptionService
{
    public function upgradeToPremium(User $user): void
    {
        Subscription::updateOrCreate(
            ['user_id' => $user->id],
            ['status' => 'premium']
        );
    }

    public function isPremium(User $user): bool
    {
        return Subscription::where('user_id', $user->id)
            ->where('status', 'premium')
            ->exists();
    }

    public function applyPremiumTheme(User $user): void
    {
        if ($this->isPremium($user)) {
            $user->theme = 'premium';
            $user->save();
        }
    }
}
