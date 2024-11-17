<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Url;
class UserTable extends Component
{
    #[Url()]
    public $search;
    #[Url()]
    public $admin='';
    #[Url()]
    public $sortBy='created_at';
    #[Url()]
    public $sortDir='ASC';
    #[Url()]
    public $perPage=5;
    public function render()
    {
        return view('livewire.user-table',[
            'users'=>User::search($this->search)
            ->when($this->admin!=='' ,function($query){
                $query->where('role',$this->admin);
            })
            ->orderBy($this->sortBy,$this->sortDir)
            ->paginate($this->perPage),
        ]);
    }
    public function setSortBy($sortBy){
        if($this->sortBy === $sortBy){
            $this->sortDir=($this->sortDir==="ASC"?"DESC":"ASC");
            return;
        }
        $this->sortBy = $sortBy;
        $this->sortDir = "ASC";
    }
    public function DeletUser($userId){
        User::find($userId)->delete();
    }
}

