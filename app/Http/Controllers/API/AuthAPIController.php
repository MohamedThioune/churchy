<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\LoginAPIRequest;
use App\Http\Requests\API\RegisterAPIRequest;
use Illuminate\Support\Facades\Hash;

class AuthAPIController extends AppBaseController
{
    /**
     * @OA\Post(
     *      path="/oauth/token",
     *      summary="oauthToken",
     *      tags={"Auth"},
     *      description="Oauth Token",
     *      @OA\RequestBody(
     *        @OA\MediaType(
     *          mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(
     *                  property="grant_type",
     *                  type="string",
     *                   description="default value 'password', 'refresh_token' for refresh token"
     *              ),
     *              @OA\Property(
     *                  property="client_id",
     *                  type="string",
     *                   description="confidential"
     *              ),
     *              @OA\Property(
     *                  property="client_secret",
     *                  type="string",
     *                   description="confidential"
     *              ),
     *              @OA\Property(
     *                  property="username",
     *                  type="string",               
     *                  description="email of the user"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="password of the user"
     *              ),
     *           ),
     *        ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */ 
    public function issueToken(Request $request)
    {
        return null;
    }

    /**
     * @OA\Post(
     *      path="/register",
     *      summary="register",
     *      tags={"Auth"},
     *      description="Register a user",
     *      @OA\RequestBody(
     *        @OA\MediaType(
     *          mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(
     *                  property="first_name",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="last_name",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="gender",
     *                  type="string",
     *                  description="Possible values('Homme', 'Femme')"
     *              ),
     *              @OA\Property(
     *                  property="role",
     *                  type="string",
     *                  description="Possible values('cashier', 'admin')"
     *              ),
     *              @OA\Property(
     *                  property="birthday",
     *                  type="date",
     *                  description="format(YYYY-MM-DD H:I:S), nullable"
     *              ),
     *              @OA\Property(
     *                  property="phone",
     *                  type="string",
     *                  description="nullable"
     *              ),
     *              @OA\Property(
     *                  property="address",
     *                  type="string",                       
     *                  description="nullable"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",                       
     *                  description="nullable"
     *              ),
     *           ),
     *        ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */
    public function register(RegisterAPIRequest $request): JsonResponse
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'birthday' => $request->has('birthday') ? $request->birthday : null,
            'phone' => $request->has('phone') ? $request->phone : null,
            'address' => $request->has('address') ? $request->address : null,
            'password' => Hash::make($request->password),
        ]);
    
        //Create the token
        $token = $user->createToken('Church' . $user->id)->accessToken;

        //Assign a cashier or admin role ?
        $user->assignRole($request->role);

        return $this->sendResponse(new UserResource($user), 'Register successfully !');
    }

    /**
     * @OA\Post(
     *      path="/logout",
     *      summary="logout",
     *      tags={"Auth"},
     *      description="Logout",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return $this->sendSuccess('Successfully logged out');
    }

    /**
     * @OA\Get(
     *      path="/user",
     *      summary="user",
     *      tags={"Auth"},
     *      description="User informations",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();
        
        return $this->sendResponse(new UserResource($user), 'User informations');
    }

    // public function forgot_password(ForgotPasswordAPIRequest $request){
    //     $input = $request->all();

    //     $user = User::where('email', $input['email'])->first();

    //     if(!empty($user)){
    //         //Generate code
    //         $code = $this->generate_code($user->email);

    //         //Send email
    //         \Mail::to($user->email)->send(new \App\Mail\CodeEmail($code));
    //         // \Mail::to($user->email)->send(new \App\Mail\ForgotPassword($code));

    //         return $this->sendResponse($code, 'Code generated successfully !');
    //     }
    //     else
    //         return response()->json(['error' => 'Email not matching with a user !'], 201);
    // }

    // public function match_code(CodePasswordAPIRequest $request){
    //     $input = $request->all();
    //     $verification = ValidationEmail::where('code', $input['code'])->first();
    //     if(empty($verification)){
    //         return response()->json(['success' => false, 'message' => 'Verification code not found !'], 201);
    //     }else{
    //         $user = User::where('email', $verification->email)->first();
    //         $user->email_verified_at = Carbon::now();
    //         $user->save();
    //         return $this->sendSuccess("Code matched successfully !");
    //     }
    // }

    // public function reset_password(ResetPasswordAPIRequest $request){
    //     $inputs = $request->all();
    //     $verification = ValidationEmail::where('code', $inputs['code'])->first();
    //     if(empty($verification))
    //         return response()->json(['success' => false, 'message' => 'Code not found !'], 201);

    //     $user = User::where('email', $verification->email)->first();

    //     $user->password = bcrypt($inputs['new_password']);
    //     $user->save();

    //     $verification->delete();

    //     return $this->sendSuccess('Password reset successfully ! ');
    // }

}
