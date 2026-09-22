<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Enums\TicketStatus;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        return UserResource::collection(User::all());
    }

    public function show(User $user): UserResource
    {
        $this->authorize('view', $user);
        return new UserResource($user);
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
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $activeStatuses = [TicketStatus::OPEN, TicketStatus::IN_PROGRESS];

        $hasActiveTickets = $user->ticketsIssued()->whereIn('status', $activeStatuses)->exists()
            || $user->ticketsAssigned()->whereIn('status', $activeStatuses)->exists();

        if ($hasActiveTickets) {
            return response()->json([
                'message' => 'Cannot delete a user that still has open or in-progress tickets assigned to it.'
            ], 409);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
