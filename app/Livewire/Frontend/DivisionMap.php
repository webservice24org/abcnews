<?php

namespace App\Livewire\Frontend;

use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Livewire\Component;


class DivisionMap extends Component
{
    public $divisions;
    public $division_id = '';
    public $district_id = '';
    public $upazila_id = '';


    public function mount()
    {
        $this->divisions = Division::all();
    }

     public function getFilteredDistrictsProperty()
    {
        return $this->division_id
            ? District::where('division_id', $this->division_id)->get()
            : collect();
    }

    public function getFilteredUpazilasProperty()
    {
        return $this->district_id
            ? Upazila::where('district_id', $this->district_id)->get()
            : collect();
    }

     public function updatedDivisionId($value)
    {
        $this->district_id = null;
        $this->upazila_id = null;

        $this->dispatch('$refresh'); 
    }


    public function updatedDistrictId($value)
    {
        $this->upazila_id = null;

        $this->dispatch('$refresh'); 
    }

   public function searchNews()
{
    if ($this->upazila_id) {
        $upazila = Upazila::find($this->upazila_id);
        return redirect()->route('upazila.show', $upazila->slug);
    }

    if ($this->district_id) {
        $district = District::find($this->district_id);
        return redirect()->route('district.show', $district->slug);
    }

    if ($this->division_id) {
        $division = Division::find($this->division_id);
        return redirect()->route('division.show', $division->slug);
    }
}


    public function render()
    {
        return view('livewire.frontend.division-map', [
            'divisions' => $this->divisions,
            'filteredDistricts' => $this->filteredDistricts,
            'filteredUpazilas' => $this->filteredUpazilas,
        ]);
    }

}

