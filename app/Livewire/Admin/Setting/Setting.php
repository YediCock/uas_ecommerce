<?php
namespace App\Livewire\Admin\Setting;

use App\Models\Setting as ModelsSetting;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;

class Setting extends Component
{
    use LivewireAlert;

    #[Layout('components.layouts.admin')]
    public $name, $value, $desc, $settings;

    public $settingsData = [];

    public function mount()
    {
        $this->settings = ModelsSetting::get();

        foreach ($this->settings as $setting) {
            $this->settingsData[$setting->id] = [
                'name' => $setting->name,
                'value' => $setting->value,
                'desc' => $setting->desc,
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.setting.setting', [
            'settings' => $this->settings
        ]);
    }

    public function editSetting($id)
    {
        $validatedData = $this->validate([
            'settingsData.' . $id . '.name' => 'required|unique:settings,name,' . $id,
            'settingsData.' . $id . '.value' => 'required',
            'settingsData.' . $id . '.desc' => 'required',
        ]);
    
        $setting = ModelsSetting::where('id', $id)->first();
    
        if ($setting) {
            $setting->update($validatedData['settingsData'][$id]);
            $this->alert('success', 'Setting berhasil diperbarui');
        } else {
            $this->alert('error', 'Setting tidak ditemukan');
        }
    }
    
}
