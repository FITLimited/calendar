<?php

namespace App\Services;

use DB;
use Route;
use Validator;
use Illuminate\Http\Request;

use App\Helpers\ActionResult;
use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    private $client;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
        $this->userRepository = $userRepository;
    }

    /**
     * @param $request
     * @return ActionResult
     */
    public function login($request)
    {
        $result = new ActionResult();

        $email = $request->email;
        $password = $request->password;

        $credentials = ['email' => $email, 'password' => $password];

        $rules = [
            'email'     => 'string|required|email',
            'password'  => 'string|required'
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->passes()) {
            $request->request->add([
                'username' => $request->email,
                'password' => $request->password,
                'grant_type' => 'password',
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'scope' => '*'
            ]);

            $proxy = Request::create(
                'oauth/token',
                'POST'
            );

            if (Route::dispatch($proxy)->getStatusCode() == 200) {
                $response = json_decode(Route::dispatch($proxy)->getContent());

                $result->setData('token', $response);
                $result->success('');
            } else {
                $result->errorUnauthorized();
            }
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

    public function create(Request $request)
    {
        $result = new ActionResult();

        $data = $request->all();

        $rules = [
            'name'      => 'string|required|min:2',
            'birthday'  => 'required|date',
            'email'     => 'string|required|email',
            'password'  => 'string|required'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $this->userRepository->create($data);

            $result->allOK();
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

//    public function remove(Request $request)
//    {
//        $user = User::find($request->id);
//        $user->delete();
//        //$this->event_service->remove($request);
//        return $request->id;
//    }
//
//    public function update(Request $request)
//    {
//        $user = User::find($request->id);
//        $user->name = $request->name;
//        $user->email = $request->email;
//        $user->birthday = $request->birthday;
//        $user->working_from = $request->working_from;
//        $user->updated_at = date("Y-m-d H:i:s");
//        $user->save();
//        return $user;
//    }

}