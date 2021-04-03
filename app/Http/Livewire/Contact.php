<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Contact extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;
    public $success;

    protected $rules = [
        'name'      => 'required',
        'email'     => 'required|email',
        'message'   => 'required|min:5'
    ];

    function updated($field){
        $this->validateOnly($field);
    }

    public function submitForm (){
        $this->validate();
        \App\Models\Contact::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'message'   => $this->message
        ]);

        $this->reset(['name','email','message']);
        $this->success = 'Your inquiry was submitted successfully!';
    }

    public function render()
    {
        return view('livewire.contact');
    }
}
