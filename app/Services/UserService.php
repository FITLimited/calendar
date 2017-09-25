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

    /**
     * @param Request $request
     * @return ActionResult
     */
    public function create(Request $request)
    {
        $result = new ActionResult();

        $data = $request->all();

        $rules = [
            'name'          => 'string|required|min:2',
            'birthday'      => 'required|date',
            'working_from'  => 'required|date',
            'email'         => 'string|required|email',
            'password'      => 'string|required'
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

    /**
     * @param Request $request
     * @return ActionResult
     */
    public function getUser(Request $request)
    {
        $result = new ActionResult();

        $userId = $request->user()->id;

        $rules = [
            'userId' => 'required|exists:users,id',
        ];

        $validator = Validator::make(['userId' => $userId], $rules);

        if ($validator->passes()) {
            $user = $this->userRepository->get($userId);

            $result->setData('user', $user);
            $result->success('');
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

    /**
     * @return ActionResult
     */
    public function getUsers() {
        $result = new ActionResult();

        $users = $this->userRepository->users();

        $result->setData('users', $users);
        $result->success('');

        return $result;
    }

    /**
     * @param Request $request
     * @return ActionResult
     */
    public function remove(Request $request)
    {
        $result = new ActionResult();

        $userId = $request->route('user');

        $rules = [
            'userId' => 'required|exists:users,id',
        ];

        $validator = Validator::make(['userId' => $userId], $rules);

        if ($validator->passes()) {
            $this->userRepository->remove($userId);

            $result->allOK();
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

    public function update(Request $request)
    {
        $result = new ActionResult();

        $data = $request->all();

        $rules = [
            'name'          => 'string|required|min:2',
            'birthday'      => 'required|date',
            'working_from'  => 'required|date',
            'email'         => 'string|required|email'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $this->userRepository->update($data);

            $result->allOK();
        } else {
            $result->errorValidation($validator->messages()->toArray());
        }

        return $result;
    }

}