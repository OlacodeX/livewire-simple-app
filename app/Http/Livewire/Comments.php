<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    use WithPagination;

    public $newComment;
    public $image;
    public $ticketId;
    // public $comments;

    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
        'ticketSelected' => 'setTicketId',
    ];

    public function mount()
    {
        // $this->comments = Comment::paginate(10);
    }
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => 'required|max:255']);
    }

    public function addComment()
    {
        $this->validate(['newComment' => 'required|max:255']);
        $image          = $this->storeImage();
        $createdComment = Comment::create([
            'body'              => $this->newComment, 'user_id' => 1,
            'image'             => $image,
            'support_ticket_id' => $this->ticketId,
        ]);
        $this->newComment = '';
        $this->image      = '';
        session()->flash('message', 'Comment added successfully 😁');
    }

    public function storeImage()
    {
        if (!$this->image) {
            return null;
        }
        // The image returned from the handleFileUpload method is a 64 bit encoded data so we need to convert it to a human understadable format like jpg or png.
        $img   = ImageManagerStatic::make($this->image)->encode('jpg');
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->image ? Storage::disk('public')->delete($comment->image) : null;
        $comment->delete();
        session()->flash('message', 'Comment deleted successfully 😊');
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::where('support_ticket_id', $this->ticketId)->latest()->paginate(2),
        ]);
    }
}
