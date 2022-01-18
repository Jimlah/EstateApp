<?php

namespace App\Services;

use App\Models\Estate;
use Auth;
use Notification;
use App\Models\User;
use App\Models\Manager;
use App\Models\Visitor;

class VisitorServices
{
    public $visitor;
    public $manager;
    public $user;

    public function __construct(Visitor $visitor, User $user, Manager $manager)
    {
        $this->visitor = $visitor;
        $this->manager = $manager;
        $this->user = $user;
    }

    public function create(array $data)
    {
        $this->visitor = $this->visitor->create($data);

        return $this;
    }

    public function approve($visitor)
    {
        $this->visitor = $this->update($visitor, ['approved' => true]);

        return $this;
    }

    public function reject($visitor)
    {
        $this->visitor = $this->update($visitor, ['approved' => false]);

        return $this;
    }

    public function update(Visitor $visitor, array $data)
    {
        $visitor->update($data);

        $this->visitor = $visitor->refresh();

        return $this;
    }

    public function notify($notification,  $user = null)
    {
        if ($this->user || $user) {
            $this->user = $user ? $user : $this->user;

            $this->user->notify(new $notification($this->visitor));
        }

        if ($this->manager) {
            Notification::send($this->manager, new $notification($this->visitor));
        }

        return $this;
    }

    public function getUser($id = null)
    {
        $this->user = $this->user->find($id ?? $this->visitor->user_id);

        return $this;
    }

    /**
     * Get the manager of the estate.
     *
     * @param  id $id estate id
     *
     * @return \App\Models\Manager
     */
    public function getManagers($id = null)
    {
        $this->manager = Estate::with('managers')
            ->find($id ?? $this->visitor->estate_id)
            ->managers;

        return $this;
    }
}
