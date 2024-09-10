<?php

namespace App\Http\Controllers;

use App\Jobs\MessageProcessJob;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ServerRequestInterface;

class MessagesController extends Controller
{

    /**
     * @OA\Schema(
     *     schema="Result",
     *     title="Sample schema for using references",
     *     @OA\Property(
     *          property="status",
     *          type="string"
     *      ),
     *     @OA\Property(
     *          property="error",
     *          type="string"
     *      )
     *  )
     * @OA\Post(
     *     path="/api/messages",
     *     summary="Adds a new message - with oneOf examples",
     *     description="Adds a new message",
     *     operationId="create",
     *     tags={"messages"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={
     *                  "name": "Jessica Smith",
     *                  "email": "JessicaSmith@mail.com",
     *                  "message": "Some message from Jessica Smith"
     *                }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Schema(ref="#/components/schemas/Result"),
     *             @OA\Examples(
     *                  example="result",
     *                  value={"name": "string", "email": "string", "message": "string"},
 *                      summary="An result object."
     *             ),
     *         )
     *     )
     * )
     */
    public function create(ServerRequestInterface $request)
    {
        $validator = Validator::make($request->getParsedBody(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        MessageProcessJob::dispatchSync(
            Message::create($validator->valid())
        );

        return json_encode($validator->valid(), JSON_THROW_ON_ERROR);
    }
}
