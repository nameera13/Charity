@extends('front.layout.default')
@section('title','Blog Details')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $post->title }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('blog') }}">Blog</a></li>
                        <li class="breadcrumb-item active">{{ $post->slug }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="post pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="left-item">
                    <div class="main-photo">
                        <img src="{{ asset('admin/uploads/posts/'.$post->photo) }}" alt="">
                    </div>
                    <div class="sub">
                        <ul>
                            <li><i class="fas fa-calendar-alt"></i> On: {{ $post_date }}</li>
                            <li><i class="fas fa-th-large"></i> Category: 
                                <a href="{{ url('category/'.$post->post_category->slug) }}">{{ $post->post_category ? $post->post_category->name : 'Uncategorized' }}</a>
                            </li>                                                    
                        </ul>
                    </div>
                    <div class="description">
                        <p>
                            {{ $post->description }}
                        </p>
                    </div>
                    <div class="tags" style="margin-top:20px; margin-bottom:15px;">
                        <h5>Tags</h5>
                        @for ($i = 0; $i < count($post_tags); $i++)
                            <a href="{{ url('tag/'.$post_tags[$i]) }}" style="background:#1455c6; padding:5px 10px; color:#fff; border-radius:6px; display:inline-block;">
                                {{ $post_tags[$i] }}
                            </a>
                        @endfor
                    </div>                    
                    <div class="comment">

                        <h2>6 Comments</h2>

                        <div class="comment-section">

                            <div class="comment-box d-flex justify-content-start">
                                <div class="left">
                                    <img src="uploads/team-1.jpg" alt="">
                                </div>
                                <div class="right">
                                    <div class="name">Patrick Smith</div>
                                    <div class="date">September 25, 2022</div>
                                    <div class="text">
                                        Qui ea oporteat democritum, ad sed minimum offendit expetendis. Idque volumus platonem eos ut, in est verear delectus. Vel ut option adipisci consequuntur. Mei et solum malis detracto, has iuvaret invenire inciderint no. Id est dico nostrud invenire.
                                    </div>
                                    <div class="reply">
                                        <a href=""><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-box reply-box d-flex justify-content-start">
                                <div class="left">
                                    <img src="uploads/team-2.jpg" alt="">
                                </div>
                                <div class="right">
                                    <div class="name">John Doe</div>
                                    <div class="date">September 25, 2022</div>
                                    <div class="text">
                                        Qui ea oporteat democritum, ad sed minimum offendit expetendis. Idque volumus platonem eos ut, in est verear delectus. Vel ut option adipisci consequuntur. Mei et solum malis detracto, has iuvaret invenire inciderint no. Id est dico nostrud invenire.
                                    </div>
                                    <div class="reply">
                                        <a href=""><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-box reply-box d-flex justify-content-start">
                                <div class="left">
                                    <img src="uploads/team-3.jpg" alt="">
                                </div>
                                <div class="right">
                                    <div class="name">Brent Smith</div>
                                    <div class="date">September 25, 2022</div>
                                    <div class="text">
                                        Qui ea oporteat democritum, ad sed minimum offendit expetendis. Idque volumus platonem eos ut, in est verear delectus. Vel ut option adipisci consequuntur. Mei et solum malis detracto, has iuvaret invenire inciderint no. Id est dico nostrud invenire.
                                    </div>
                                    <div class="reply">
                                        <a href=""><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="comment-section">
                            <div class="comment-box d-flex justify-content-start">
                                <div class="left">
                                    <img src="uploads/team-2.jpg" alt="">
                                </div>
                                <div class="right">
                                    <div class="name">John Doe</div>
                                    <div class="date">September 25, 2022</div>
                                    <div class="text">
                                        Qui ea oporteat democritum, ad sed minimum offendit expetendis. Idque volumus platonem eos ut, in est verear delectus. Vel ut option adipisci consequuntur. Mei et solum malis detracto, has iuvaret invenire inciderint no. Id est dico nostrud invenire.
                                    </div>
                                    <div class="reply">
                                        <a href=""><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="comment-section">
                            <div class="comment-box d-flex justify-content-start">
                                <div class="left">
                                    <img src="uploads/team-1.jpg" alt="">
                                </div>
                                <div class="right">
                                    <div class="name">John Doe</div>
                                    <div class="date">September 25, 2022</div>
                                    <div class="text">
                                        Qui ea oporteat democritum, ad sed minimum offendit expetendis. Idque volumus platonem eos ut, in est verear delectus. Vel ut option adipisci consequuntur. Mei et solum malis detracto, has iuvaret invenire inciderint no. Id est dico nostrud invenire.
                                    </div>
                                    <div class="reply">
                                        <a href=""><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="mt_40"></div>

                        <h2>Leave Your Comment</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Comment"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-long-arrow-alt-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-12">
                <div class="right-item">
                    <h2>Latest Posts</h2>
                    <ul>
                        @foreach ($latest_posts as $value)
                            <li><a href="{{ url('blog/'.$value->slug) }}"><i class="fas fa-angle-right"></i> {{ $value->title }} </a></li>
                        @endforeach
                    </ul>

                    <h2 class="mt_40">Categories</h2>
                    <ul>
                        @foreach ($post_categories as $value)
                        <li><a href="{{ url('category/'.$value->slug) }}"><i class="fas fa-angle-right"></i> {{ $value->name }} </a></li>
                        @endforeach
                    </ul>

                    <h2 class="mt_40">Tags</h2>
                    <ul class="tag">
                        @for ($i = 0; $i < count($tags); $i++)
                            <li><a href="{{ url('tag',$tags[$i]) }}">{{ $tags[$i] }}</a></li>
                        @endfor
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection