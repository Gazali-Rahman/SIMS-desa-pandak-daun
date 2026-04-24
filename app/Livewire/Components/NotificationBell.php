<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $isOpen = false;

    public function getListeners()
    {
        return [
            "echo-private:App.Models.User.{$this->getUserId()},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'loadNotifications',
        ];
    }

    public function getUserId()
    {
        // return auth()->id();
        return Auth::id();
    }

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $this->notifications = $user->unreadNotifications()->take(5)->get();
            $this->unreadCount = $user->unreadNotifications()->count();
        }
    }

    public function markAsRead($id, $url)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        return redirect()->to($url);
    }

    public function markAllAsRead()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        $this->loadNotifications();
        $this->isOpen = false;
    }

    public function toggleDropdown()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.components.notification-bell');
    }
}
