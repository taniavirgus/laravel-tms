<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardLayout extends Component
{
  /**
   * Get the view / contents that represents the component.
   */
  public function render(): View
  {
    $check = Auth::check();

    if (!$check) return view('layouts.public');
    return view('layouts.dashboard');
  }
}
