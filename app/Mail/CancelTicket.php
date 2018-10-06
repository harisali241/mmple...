<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\PrintedTicket;

class CancelTicket extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $id = $this->data->id;
        if(is_array($id)){
            $cancelTickets = PrintedTicket::whereBetween('id', $id)->with('show_times.movies', 'show_times.screens')->get();
        }else{
            $cancelTickets = PrintedTicket::where('id', $id)->with('show_times.movies', 'show_times.screens')->get();
        }
        return $this->view('layouts.cancelTicketMail', compact('cancelTickets'));
    }
}
