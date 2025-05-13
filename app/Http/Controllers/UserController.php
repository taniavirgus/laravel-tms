<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
  /**
   * Create a new controller instance.
   * 
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(User::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');
    $role = $request->input('role');

    $users = User::query()
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('email', 'like', '%' . $search . '%');
      })
      ->when($role, function ($q) use ($role) {
        $q->where('role', $role);
      })
      ->paginate(10)
      ->withQueryString();


    return view('dashboard.users.index', [
      'users' => $users,
      'roles' => RoleType::cases(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('dashboard.users.create', [
      'user' => new User(),
      'roles' => RoleType::cases()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreUserRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $user = User::create($validated);

    return redirect()
      ->route('users.index')
      ->with('success', 'User created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user): View
  {
    return view('dashboard.users.edit', [
      'user' => $user,
      'roles' => RoleType::cases()
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateUserRequest $request, User $user): RedirectResponse
  {
    $validated = $request->validated();
    $empty = empty($validated['password']);

    if ($empty) unset($validated['password']);
    $user->update($validated);

    return redirect()
      ->route('users.index')
      ->with('success', 'User updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user): RedirectResponse
  {
    $user->delete();

    return redirect()
      ->route('users.index')
      ->with('success', 'User deleted successfully.');
  }
}
