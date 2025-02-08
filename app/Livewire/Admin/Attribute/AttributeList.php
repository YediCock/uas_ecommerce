<?php

namespace App\Livewire\Admin\Attribute;

use App\Models\Attribute;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
class AttributeList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $attributesData = [];
    public $name, $getAttributes, $status;
    public function mount()
    {
        $this->loadAttributes();

        foreach ($this->getAttributes as $attribute) {
            $this->attributesData[$attribute->id] = [
                'name' => $attribute->name,
                'status' => $attribute->status,
            ];
        }
    }
    public function loadAttributes()
    {
        $this->getAttributes = Attribute::where('status', '!=', 'deleted')->get();
    }
    public function render()
    {
        return view('livewire.admin.attribute.attribute-list', [
            'attributes' => $this->getAttributes
        ]);
    }
    public function addAttribute()
    {
        $validatedData = $this->validate([
            'name' => 'required|unique:categories',
            'status' => 'required|in:active,nonactive',
        ]);
    
        // Handle store creation
        Attribute::create([
            'name' => $this->name,
            'status' => $this->status,
        ]);
    
        $this->reset(['name', 'status']); // Reset form fields
    
        $this->alert('success', 'Atribute berhasil ditambahkan');
        
        // refresh halaman
        $this->mount();
    
        return back();
    }
    public function editAttribute($id)
    {
        $validatedData = $this->validate([
            'attributesData.' . $id . '.name' => 'required|unique:attributes,name,' . $id,
            'attributesData.' . $id . '.status' => 'required',
        ]);
    
        $attribute = Attribute::where('id', $id)->first();
    
        if ($attribute) {
            $attribute->update($validatedData['attributesData'][$id]);
            $this->alert('success', 'Atribut berhasil diperbarui');
        } else {
            $this->alert('error', 'Atribut tidak ditemukan');
        }
    }
    public function deleteAttribute($id)
    {
        $attribute = Attribute::where('id', $id)->first();

        $attribute->status = "deleted";
        $attribute->save();

        // muat ulang data
        $this->loadAttributes();

        $this->alert('success', 'Berhasil menghapus atribut ini');
        return back();
    }
}
