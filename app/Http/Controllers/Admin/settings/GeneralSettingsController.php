<?php

namespace App\Http\Controllers\Admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use App\Http\Requests\Admin\GeneralSettingsRequest;

class GeneralSettingsController extends Controller
{
    public function view(GeneralSettings $settings)
    {
        return view('admin.settings.general', compact('settings'));
    }
    public function update(GeneralSettings $settings, GeneralSettingsRequest $request)
    {
        $validated = $request->validated();
        $settings->company_name = $validated['company_name'];
        $settings->company_email = $validated['company_email'];
        $settings->company_phone = $validated['company_phone'];
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $fileName, 'public');
            $settings->company_logo = $path;
        }
        $settings->save();
        return to_route('admin.settings.general.view')->with('success', __('trans.settings_updated'));
    }
}
