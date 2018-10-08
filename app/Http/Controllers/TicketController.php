<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use App\Models\Batch;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission')->except('store' , 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets =  Ticket::all();
        return view('pages.admin.ticket.viewTickets', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.ticket.addticket');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'isChild' => 'required',
            'adultPrice' => 'required',
            'type' => 'required',
        ]);

        $ticket_id = Ticket::createTicket($request);
        Batch::createBatch($ticket_id, 'web_tickets', 'store');
        Batch::runBatch();
        
        return redirect('ticket/create')->withMessage('Added Ticket Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {       
        $ticket = Ticket::where('id', $ticket->id)->get()->first();
        return view('pages.admin.ticket.editTicket', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'isChild' => 'required',
            'adultPrice' => 'required',
            'type' => 'required',
        ]);

        $ticket_id = Ticket::updateTicket($request, $id);
        Batch::createBatch($ticket_id, 'web_tickets', 'update');
        Batch::runBatch();

        return redirect('ticket')->withMessage('Update Ticket Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {   
        $s_id = ShowTime::where('ticket_id', $ticket->id)->get();
        if(count($s_id) <= 0){
            Ticket::findOrFail($ticket->id)->delete();
            Batch::createBatch($ticket->id, 'web_tickets', 'delete');
            Batch::runBatch();
            return redirect('ticket')->withMessage('Delete Ticket Sucessfully');
        }else{
            return redirect('ticket')->withErrors('Ticket type present in showtimes!');
        }
    }
}
