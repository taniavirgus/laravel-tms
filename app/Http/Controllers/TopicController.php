<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopicController extends Controller
{
  /**
   * Create a new controller instance.
   * 
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(Topic::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');

    $topics = Topic::query()
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
      })
      ->paginate(5);

    return view('dashboard.topics.index', [
      'topics' => $topics
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('dashboard.topics.create', [
      'topic' => new Topic()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreTopicRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $topic = Topic::create($validated);

    return redirect()
      ->route('topics.index')
      ->with('success', 'Topic created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Topic $topic): View
  {
    return view('dashboard.topics.show', [
      'topic' => $topic
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Topic $topic): View
  {
    return view('dashboard.topics.edit', [
      'topic' => $topic
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTopicRequest $request, Topic $topic): RedirectResponse
  {
    $validated = $request->validated();
    $topic->update($validated);

    return redirect()
      ->route('topics.index')
      ->with('success', 'Topic updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Topic $topic): RedirectResponse
  {
    $topic->delete();

    return redirect()
      ->route('topics.index')
      ->with('success', 'Topic deleted successfully.');
  }
}
