<?php

namespace App\Livewire\Frontend;

use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Livewire\Component;

class DivisionMap extends Component
{
    public $divisions;
    public $districts = [];
    public $upazilas = [];

    public $selectedDivision = '';
    public $selectedDistrict = '';
    public $selectedUpazila = '';

    public function mount()
    {
        $this->divisions = Division::all();
    }

    public function updatedSelectedDivision($divisionId)
    {
        $this->districts = District::where('division_id', $divisionId)->get();
        $this->selectedDistrict = '';
        $this->upazilas = [];
        $this->selectedUpazila = '';
    }

    public function updatedSelectedDistrict($districtId)
    {
        $this->upazilas = Upazila::where('district_id', $districtId)->get();
        $this->selectedUpazila = '';
    }

    public function searchNews()
    {
        if ($this->selectedUpazila) {
            $upazila = Upazila::find($this->selectedUpazila);
            return redirect()->route('upazila.show', $upazila->slug);
        }

        if ($this->selectedDistrict) {
            $district = District::find($this->selectedDistrict);
            return redirect()->route('district.show', $district->slug);
        }

        if ($this->selectedDivision) {
            $division = Division::find($this->selectedDivision);
            return redirect()->route('division.show', $division->slug);
        }
    }

    public function render()
    {
        return view('livewire.frontend.division-map');
    }
}
