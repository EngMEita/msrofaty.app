<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\UserStoreRequest;
use App\Http\Requests\Acp\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = auth()->user()->household()->users()->get();

        return view('acp.user.index', compact('users'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('acp.user.create');
    }

    /**
     * @param \App\Http\Requests\Acp\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        abort_unless(auth()->user()->household()->pivot->role === 'owner', 403);
        $data = $request->validated();
        unset($data['email_verified_at'], $data['remember_token']);
        $user = User::create($data);
        auth()->user()->household()->users()->attach($user->id, ['role' => 'editor']);

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('acp.user.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->assertMember($user);
        return view('acp.user.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $this->assertMember($user);
        return view('acp.user.edit', compact('user'));
    }

    /**
     * @param \App\Http\Requests\Acp\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->assertMember($user);
        $data = [
            'name'  => $request->name ,
            'email' => $request->email
        ];
        if($request->password)
        {
            $data['password'] = $request->password ;
        }

        // $user->update($request->validated());
        $user->update($data) ;

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('acp.user.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        abort_unless(auth()->user()->household()->pivot->role === 'owner', 403);
        $this->assertMember($user);
        abort_if($user->id === auth()->id(), 422, 'The household owner cannot remove themselves.');
        auth()->user()->household()->users()->detach($user->id);
        $user->delete();

        return redirect()->route('acp.user.index');
    }

    private function assertMember(User $user): void
    {
        abort_unless(auth()->user()->household()->users()->whereKey($user->id)->exists(), 404);
    }
}
