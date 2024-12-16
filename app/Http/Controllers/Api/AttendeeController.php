<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationShips;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{

    use CanLoadRelationShips;

    protected readonly array $relations;

    public function __construct()
    {
        $this->relations = ['user'];
    }

    public function index(Event $event)
    {
        $attendees = $this->loadRelationships($event->attendees()->latest());

        return AttendeeResource::collection($attendees->paginate());
    }

    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id'=>i
        ]);

        return new AttendeeResource($this->loadRelationships($attendee));
    }


    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($this->loadRelationships($attendee));
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Event $event, Attendee $attendee)
    {
        $attendee->delete();

        return response(status:204);
    }
}
