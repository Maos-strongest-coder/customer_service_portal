<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        return UserResource::collection(User::all());
    }

    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User)
    {
        $this->authorize('delete', $User);

        if ($User->tickets()->exists()) {
            return response()->json([
                'message' => 'Cannot delete a User that still has tickets assigned to it.'
            ], 409);
        }

        $User->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
