<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\SendMessageRequest;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use phpcent\Client as CentrifugoClient;

use function Psy\debug;

class MessageController extends Controller
{

    private CentrifugoClient $centrifugoClient;

    public function __construct()
    {
        $this->centrifugoClient = new CentrifugoClient("http://localhost:8500/api");
        $this->centrifugoClient->setApiKey("bd446004-bad6-4945-9945-d6396d5e4c18");
        $this->centrifugoClient->setSecret("114cf1d6-c3fa-482d-9429-52ea4d946201");
    }

    /**
     * Endpoint: POST /api/send
     *
     * This is the main endpoint that a client (JS web app, Android app, iOS app, etc.) will
     * hit in order to send a message to another user.
     */
    public function send(SendMessageRequest $request, Room $room): JsonResponse
    {
        $message = new Message;
        $message->body = $request->input('body');
        $message->room_id = $room->id;
        $message->from_user_id=$request->user()->id;
        $message->save();
        $message->load('user');
        $this->centrifugoClient->broadcast(["$room->id"], ['message'=>$message]);
        return new JsonResponse($status=200);
    }

    /**
     * Endpoint: GET /api/messages/
     */
    public function index(Room $room): JsonResponse
    {
        return response()->json(['messages'=>$room->messages]);
    }
}
