<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';

    public string $address = '';
    public string $about = '';
    public ?string $dob = '';
    public string $nid_number = '';
    public string $mobile_number = '';
    public $profile_photo;
    public ?string $photo_preview = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        $profile = $user->profile;
        if ($profile) {
            $this->address = $profile->address ?? '';
            $this->about = $profile->about ?? '';
            $this->dob = $profile->dob ?? '';
            $this->nid_number = $profile->nid_number ?? '';
            $this->mobile_number = $profile->mobile_number ?? '';
            $this->photo_preview = $profile->profile_photo ?? null;

        }
    }

    public function updateProfileInformation(): void
{
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        'address' => 'nullable|string|max:255',
        'about' => 'nullable|string|max:1000',
        'dob' => 'nullable|date',
        'nid_number' => 'nullable|string|max:30',
        'mobile_number' => 'nullable|string|max:20',
        'profile_photo' => 'nullable|image|max:2048',
    ]);

    $user->fill([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    // Apply news-style logic to profile photo
    $profileData = collect($validated)->except(['name', 'email'])->toArray();

    $existingPhoto = $user->profile?->profile_photo;

    if ($this->profile_photo) {
    // Store the image publicly
        $newPhoto = $this->profile_photo->store('profile_photos', 'public');

        // Set visibility (important!)
        Storage::disk('public')->setVisibility($newPhoto, 'public');

        // Set 644 permission on file system (if needed)
        $fullPath = storage_path('app/public/' . $newPhoto);
        if (file_exists($fullPath)) {
            chmod($fullPath, 0644); // read for everyone
        }

        // Delete old one
        if ($existingPhoto && \Storage::disk('public')->exists($existingPhoto)) {
            Storage::disk('public')->delete($existingPhoto);
        }

        $profileData['profile_photo'] = $newPhoto;
        $this->photo_preview = $newPhoto;
    }
 else {
        $profileData['profile_photo'] = $existingPhoto;
    }

    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $profileData
    );

    $this->dispatch('profile-updated', name: $user->name);

    $this->dispatch('toast', [
        'type' => 'success',
        'message' => 'Profile updated successfully!',
    ]);

    $this->redirect(request()->header('Referer') ?? route('profile.show'), navigate: true);
}




    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
};
?>


<section class="w-full">
    @include('partials.settings-heading')

    
        <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile and contact information')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <flux:text class="mt-4">
                        {{ __('Your email address is unverified.') }}

                        <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if (session('status') === 'verification-link-sent')
                        <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                    @endif
                </div>
            @endif

            <flux:input wire:model="address" :label="__('Address')" type="text" />
            <flux:textarea wire:model="about" :label="__('About You')" />
            <flux:input wire:model="dob" :label="__('Date of Birth')" type="date" />
            <flux:input wire:model="nid_number" :label="__('NID Number')" type="number" />
            <flux:input wire:model="mobile_number" :label="__('Mobile Number')" type="text" />

            <div>
                <label class="block text-sm text-black font-medium mb-1">Profile Picture</label>
                <input type="file" wire:model="profile_photo" class="w-full border rounded p-2" />
                @if ($profile_photo)
                    <img src="{{ $profile_photo->temporaryUrl() }}" class="w-20 h-20 mt-2 rounded-full" />
                @elseif ($photo_preview)
                    <img src="{{ url('storage/' . $photo_preview) }}" class="w-20 h-20 mt-2 rounded-full" />
                @endif


            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
        
                <livewire:settings.delete-user-form />
        
    </x-settings.layout>
    
</section>

@push('scripts')
<script>
    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message); // You must have showToast() implemented globally
    });
</script>
@endpush
