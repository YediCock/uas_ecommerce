<?php

namespace App\Livewire\Admin\Attribute;

use App\Models\Attribute;
use Livewire\Component;
use App\Models\AttributeValue;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AttributeValueList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $attributeValuesData = [];
    public $name, $getAttributeValues, $status, $attribute;
    public function mount($id)
    {
        $this->attribute = Attribute::where('id', $id)->first();
        $this->getAttributeValues = AttributeValue::where('attribute_id', $id)->where('status', '!=', 'deleted')->get();

        foreach ($this->getAttributeValues as $attribute) {
            $this->attributeValuesData[$attribute->id] = [
                'name' => $attribute->name,
                'status' => $attribute->status,
            ];
        }
    }
    public function render()
    {
        return view('livewire.admin.attribute.attribute-value-list', [
            'attributeValues' => $this->getAttributeValues
        ]);
    }
    public function addAttributeValue()
    {
        $validatedData = $this->validate([
            'name' => 'required|unique:categories',
            'status' => 'required|in:active,nonactive',
        ]);
    
        // Handle store creation
        AttributeValue::create([
            'attribute_id' => $this->attribute->id,
            'name' => $this->name,
            'status' => $this->status,
        ]);
    
        $this->reset(['name', 'status']); // Reset form fields
    
        $this->alert('success', 'Atribute berhasil ditambahkan');
        
        // refresh halaman
        $this->mount($this->attribute->id);
    
        return back();
    }
    public function editAttributeValue($id)
    {
        $validatedData = $this->validate([
            'attributeValuesData.' . $id . '.name' => 'required|unique:attributes,name,' . $id,
            'attributeValuesData.' . $id . '.status' => 'required',
        ]);
    
        $attributeValue = AttributeValue::where('id', $id)->first();
    
        if ($attributeValue) {
            $attributeValue->update($validatedData['attributeValuesData'][$id]);
            $this->alert('success', 'Atribut value berhasil diperbarui');
        } else {
            $this->alert('error', 'Atribut value tidak ditemukan');
        }
    }
    public function deleteAttribute($id)
    {
        $attributeValue = AttributeValue::where('id', $id)->first();

        $attributeValue->status = "deleted";
        $attributeValue->save();

        $this->alert('success', 'Berhasil menghapus atribut value ini');

        // refresh halaman
        $this->mount($this->attribute->id);

        return back();
    }
}
