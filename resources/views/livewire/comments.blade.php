<div>
    {{-- form --}}
    <h1 class="text-3xl">Comments</h1>
    @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    <div>
        @if (session()->has('message'))
        <div class="p-3 bg-green-300 text-green-800 rounded shadow-sm">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <section>
        @if($image)
        <img src={{$image}} width="200" />
        @endif
        <input type="file" id="image" wire:change="$emit('fileChoosen')">
    </section>
    {{-- .prevent on the submit action prevents default calling of the addComment function on till the submit button is clicked --}}
    <form class="my-4 flex" wire:submit.prevent="addComment">
        <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="What's in your mind."
            wire:model.lazy="newComment">
        <div class="py-2">
            <button type="submit" class="p-2 bg-blue-500 w-20 rounded shadow text-white">Add</button>
        </div>
    </form>
    {{-- comments --}}
    @foreach($comments as $comment)
    <div class="rounded border shadow p-3 my-2">
        <div class="flex justify-between my-2">
            <div class="flex">
                <p class="font-bold text-lg">{{$comment->creator->name}}</p>
                <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">{{$comment->created_at->diffForHumans()}}
                </p>
            </div>
            <i class="fas fa-times text-red-200 hover:text-red-600 cursor-pointer"
                wire:click="remove({{$comment->id}})"></i>
        </div>
        <p class="text-gray-800">{{$comment->body}}</p>
        @if($comment->image)
        {{-- There is an accessor in the comment model that constructs the image path by prefixing the image url from the db with the app's public part before returning it --}}
        <img src="{{$comment->imagePath}}" />
        @endif
    </div>
    @endforeach
{{-- pagination-links here references the custom pagination file created in the views folder. Livewire will use this with any design it has to render the pagination --}}
    {{$comments->links('pagination-links')}}
</div>

<script>
    // Listiner to the fileChoosen function we are emitting on the file upload input field
    window.livewire.on('fileChoosen', () => {
        let inputField = document.getElementById('image')
        let file = inputField.files[0]
        let reader = new FileReader();
        reader.onloadend = () => {
            // Now emmit the function 'fileUpload' for our component controller to listen to and save in the db
            window.livewire.emit('fileUpload', reader.result)
        }
        reader.readAsDataURL(file);

    })
</script>