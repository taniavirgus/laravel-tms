<?php

namespace App\Http\Controllers;

use App\Enums\LevelType;
use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PositionController extends Controller
{
  /**
   * Create a new controller instance.
   * 
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(Position::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');

    $positions = Position::query()
      ->withCount('employees')
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('description', 'like', '%' . $search . '%');
      })
      ->with(['employees' => function ($query) {
        $query->select('id', 'name', 'position_id')->limit(3);
      }])
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.positions.index', [
      'positions' => $positions
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('dashboard.positions.create', [
      'levels' => LevelType::cases(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StorePositionRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $position = Position::create($validated);

    return redirect()
      ->route('positions.index')
      ->with('success', 'Position created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Position $position): View
  {
    return view('dashboard.positions.edit', [
      'levels' => LevelType::cases(),
      'position' => $position
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatePositionRequest $request, Position $position): RedirectResponse
  {
    $validated = $request->validated();
    $position->update($validated);

    return redirect()
      ->route('positions.index', $position)
      ->with('success', 'Position updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Position $position): RedirectResponse
  {
    $position->delete();

    return redirect()
      ->route('positions.index')
      ->with('success', 'Position deleted successfully.');
  }
}
