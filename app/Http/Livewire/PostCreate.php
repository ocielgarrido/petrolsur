<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Carbon\Carbon;
use DateTime;


class PostCreate extends Component
{
    public $post;
    public $postId;
    public $action;
    public $button;

    protected function getRules(){   
        if( $this->action == "updatePost"){
            $rules = [
                'post.fecha' => 'required|date|unique:posts,fecha,' .$this->postId,
            ];
        }else{
            $rules = [
                'post.fecha' => 'required|date|unique:posts,fecha',
            ];

        }
        return array_merge([
            'post.obs' => 'required',
            'post.area_id' => 'required',
  
        ], $rules);

    }


    public function createPost(){
        $this->resetErrorBag();
        $this->validate();    
        
        Post::create(
            [
                "area_id" =>1,
                "fecha" => $this->post->fecha,
                "obs" => $this->post->obs,
                "estado" => 'Creado',
                
            ]
            );
        $this->emit('saved');
        $this->reset('post');
        return redirect()->to('/post');

    }

    public function updatePost() {
        $this->resetErrorBag();
        $this->validate();

        Post::query()
            ->where('id', $this->postId)           
            ->update([
                "area_id" => 1,
                "fecha" => $this->post->fecha,
                "obs" => $this->post->obs,
                "estado" => 'Modificado',
 
            ]);
         
       $this->reset('post');
        return redirect()->to('/post');

    }

    public function mount ()
    {
        if (!$this->post && $this->postId) {
            $this->post = Post::find($this->postId);
            $this->post->area_id=1; 
            $this->post->fecha=date_format($this->post->fecha,"d-m-Y");
            $this->primerDia=(new DateTime($this->post->fecha))->modify('first day of this month')->format('d-m-Y');;

        }else{
            $this->post = new Post; 
            $carbon = new \Carbon\Carbon();
            $this->post->fecha= $carbon->now();
            $date=date_create($this->post->fecha);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->post->area_id=1;
            $this->post->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->post->fecha))->modify('first day of this month')->format('d-m-Y');;

        }
           $this->button = create_button($this->action, "Post");
    }

    public function render()
    {
        return view('livewire.post-create');
    }
}
