<?php

namespace App\Http\Controllers;

use App\Models\Repo;
use App\Models\Actor;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    /**
     * 1. Erasing all the events.
     *
     * @return \Illuminate\Http\Response
     */
    public function erase()
    {
       Event::query()->delete();
       Actor::query()->delete();
       Repo::query()->delete();

    }


    /**
     * 2. Adding new events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validating if an event with the same id already exists
        $validator = Validator::make($request->all(), [
            'id' => 'unique:events,id',
        ]);

        //if validation fails return 400
        if ($validator->fails()) {
            return response('', 400);
        }

        //Adding new event to DB
        $event = new Event;
        $event->id = $request['id'];
        $event->type = $request['type'];
        $event->actor = $request['actor']['id'];
        $event->repo = $request['repo']['id'];
        $event->created_at = $request['created_at'];
        $event->save();

        //Adding new actor to DB with relations to event
        $actor = new Actor;
        $actor->id = $request['actor']['id'];
        $actor->event_id = $request['id']; //relations
        $actor->login = $request['actor']['login'];
        $actor->avatar_url = $request['actor']['avatar_url'];
        $actor->save();

        //Adding new repo to DB with relations to event
        $repo = new Repo;
        $repo->id = $request['repo']['id'];
        $repo->name = $request['repo']['name'];
        $repo->url = $request['repo']['url'];
        $repo->event_id = $request['id']; //relations
        $repo->save();

        return response('', 201);
    }


    /**
     * 3. Returning all the events and sorting by asc
     *
     * @return \Illuminate\Http\Response
     */
    public function allEvents()
    {
        $events = Event::with(['actor', 'repo'])->orderBy('id', 'asc')->get();
        $events = $this->unsetUnwantedFields($events);
        return $events;
    }


    /**
     * 4. Returning the event records filtered by the actor ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filter($actorId)
    {
        //First validate if actor id exits
      if(Actor::find($actorId)){
          //if id exits return events
        $result = Event::with(['actor','repo'])->whereHas('actor', function(Builder $query) use($actorId) {
            $query->where('id', $actorId);
        })->get();
      }else{
          //if id doesn't exit return 400
        return response('', 400);
      }
        return response($this->unsetUnwantedFields($result), 200);;
    }

    /**
     * 5. Updating the avatar URL of the actor.
     *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function updateActor(Request $request)
    {
        $actor = Actor::find($request['id']);
        //first validate if actor exists
        if($actor){
            //if actor exits then update details
            $actor->update($request->all());
            //if any other field was updated return 400
            if($actor->wasChanged('login') || $actor->wasChanged('id')){
                return response('', 400);
            }else{
                return response('', 200);
            }
        }else{
            //if actor doesn't exit, return 404
            return response('', 404);
        }
    }
     /**
     * 6. Returning the actor records ordered by the total number of events
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function showActors()
    {
        $actors = Actor::select('id','login','avatar_url')
                        ->withCount('events')
                        ->distinct()
                        ->orderBy('events_count', 'desc')
                        ->get();

         return $actors;
    }

    /**
     * 7. Returning the actor records ordered by the maximum streak
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function streak()
    {
        $actors = Actor::select('id','login','avatar_url')
                        ->withCount('events')
                        ->distinct()
                        ->orderBy('events_count', 'desc')
                        ->get();

        return $actors;
    }

    /**
     * unsetting unwanted fields to make response look cleaner.
     */
    private function unsetUnwantedFields($result)
    {
        $jsonArray = json_decode($result, true);
        unset($jsonArray[0]['actor'][0]['event_id']);
        unset($jsonArray[0]['repo'][0]['event_id']);
        return $newJson = json_encode($jsonArray);
    }
}
