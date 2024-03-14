<?php

namespace App\Http\Controllers\Centrifuge;

use App\Http\Controllers\Controller;
use App\Http\Requests\CentrifugoTokenRequest;
use Illuminate\Http\JsonResponse;
use phpcent\Client as CentrifugoClient;

class CentrifugeController extends Controller
{

    private CentrifugoClient $centrifugoClient;

    public function __construct()
    {
        $this->centrifugoClient = new CentrifugoClient("http://localhost:8500/api");
        $this->centrifugoClient->setApiKey("bd446004-bad6-4945-9945-d6396d5e4c18");
        $this->centrifugoClient->setSecret("114cf1d6-c3fa-482d-9429-52ea4d946201");
    }

    /**
     * @param CentrifugoTokenRequest $request
     * @return JsonResponse
     */
    public function getToken(CentrifugoTokenRequest $request): JsonResponse
    {
        $token = $this->centrifugoClient->generateConnectionToken($request->user()->id);
        return response()->json(['ws_token'=>$token]);
    }
}
