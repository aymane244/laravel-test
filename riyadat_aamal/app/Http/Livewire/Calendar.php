<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class Calendar extends Component
{

    public $events = [];

    // show
    public function render()
    {
        $this->events = json_encode(
        Event::where(function ($query) { $query->where('id_entreprise', Auth::id())->orWhere('id_entreprise_rendez_vous', Auth::id()); })
        ->where(function ($query) {$query->where('etat_rendez_vous', 'valider')->orWhere('etat_rendez_vous', null); })
        ->get());
        return view('livewire.calendar');
    }

    // update
    public function eventChange($event)
    {
        $e = Event::find($event['id']);
        $e->start = $event['start'];
        if(Arr::exists($event, 'end')) {
            $e->end = $event['end'];
        }
        $e->save();
    }

    // Ajouter 1
    public function eventAdd($event,$id_entreprise)
    {
        Event::create([
            'id'=>$event['id'],
            'title'=>$event['title'],
            'start'=>$event['start'],
            'end'=>$event['end'],
            'id_entreprise'=>$id_entreprise,
        ]);
    }

    // Delete
    public function eventRemove($id)
    {
        Event::destroy($id);
    }

}
