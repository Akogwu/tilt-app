<div>
    <div class="mb-2">
        <h1 class="font-bold text-2xl text-center text-gray-600">Get In Touch</h1>
    </div>

    @if($success)
        <div class="inline-flex overflow-hidden w-full rounded-lg shadow-2xl">
            <div class="flex items-center justify-center w-12 bg-green-500"></div>
            <div class="px-3 py-2 text-left">
                <span class="font-semibold text-green-500">Success</span>
                <p class="mb-1 text-sm leading-none text-gray-500">{{ $success }}</p>
            </div>
        </div>
    @endif
    <form wire:submit.prevent="submitForm" action="" method="POST" class="flex flex-col">
        @csrf
        <div class="mb-4 mt-3 rounded bg-gray-200">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2 mt-1 ml-3">Name</label>
            <input wire:model.lazy="name" type="text" id="name" class="bg-gray-200 w-full border-none rounded text-gray-700 focus:outline-none px-3 pb-3">
        </div>
        @error('name')
        <p class="text-red-500  text-sm mb-1 -mt-3">{{ $message }}</p>
        @enderror

        <div class="mb-4 mt-3 rounded bg-gray-200">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2 mt-1 ml-3">Email Address</label>
            <input wire:model.lazy="email" type="email" id="email" class="bg-gray-200 w-full border-none rounded text-gray-700 focus:outline-none px-3 pb-3">
        </div>

        @error('email')
        <p class="text-red-500 text-sm mb-1 -mt-3">{{ $message }}</p>
        @enderror

        <div class="mb-4 mt-3 rounded bg-gray-200">
            <label for="message" class="block text-gray-700 text-sm font-bold mb-2 mt-1 ml-3">Message</label>
            <textarea wire:model.lazy="message" name="message" id="message" class="bg-gray-200 w-full border-none rounded text-gray-700 focus:outline-none px-3 pb-3"></textarea>
        </div>
        @error('message')
        <p class="text-red-500 text-sm mb-2 -mt-3">{{ $message }}</p>
        @enderror
        <button class="bg-green-600 hover:bg-green-700 font-bold py-3 rounded shadow-lg hover:shadow-xl text-white transition duration-200">Send Message</button>
    </form>
</div>
