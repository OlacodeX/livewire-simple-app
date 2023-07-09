<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SupportTicket;

class Tickets extends Component
{
    public $active ;

    protected $listeners = [
        'ticketSelected' => 'setTicketId',
    ];

    public function setTicketId($ticketId)
    {
        $this->active = $ticketId;
    }

    public function render()
    {
        return view('livewire.tickets', [
            'tickets' => SupportTicket::all(),
        ]);
    }
}
