@extends('admin.layout.default')
@section('title','Admin Home Page Item')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>{{ $module_name }}</h1>
    </div>
    <div class="section-body">
        <form action="{{ url('admin/home-page-item') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row d-flex align-items-stretch">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">                        
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-cause-tab" data-bs-toggle="tab" data-bs-target="#nav-cause" type="button" role="tab" aria-controls="nav-cause" aria-selected="true">Cause</button>
                                <button class="nav-link" id="nav-feature-tab" data-bs-toggle="tab" data-bs-target="#nav-feature" type="button" role="tab" aria-controls="nav-feature" aria-selected="false">Feature</button>
                                <button class="nav-link" id="nav-event-tab" data-bs-toggle="tab" data-bs-target="#nav-event" type="button" role="tab" aria-controls="nav-event" aria-selected="false">Event</button>
                                <button class="nav-link" id="nav-testimonial-tab" data-bs-toggle="tab" data-bs-target="#nav-testimonial" type="button" role="tab" aria-controls="nav-testimonial" aria-selected="false">Testimonial</button>
                                <button class="nav-link" id="nav-blog-tab" data-bs-toggle="tab" data-bs-target="#nav-blog" type="button" role="tab" aria-controls="nav-blog" aria-selected="false">Blog</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-cause" role="tabpanel"aria-labelledby="nav-cause-tab" tabindex="0">
                                    <!---- Cause - Start ---->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Heading</label>
                                                <input type="text" name="cause_heading" id="cause_heading" value="{{ $home_page_items->cause_heading }}" class="form-control">
                                                @error('cause_heading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Sub Heading</label>
                                                <input type="text" name="cause_subheading" id="cause_subheading" value="{{ $home_page_items->cause_subheading }}" class="form-control">
                                                @error('cause_subheading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select name="cause_status" id="cause_status" class="form-control">
                                                    <option value="show" @if($home_page_items->cause_status == "show") selected @endif>Show</option>
                                                    <option value="hide" @if($home_page_items->cause_status == "hide") selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Cause - End ---->
                                </div>
                                <div class="tab-pane fade" id="nav-feature" role="tabpanel" aria-labelledby="nav-feature-tab" tabindex="0">
                                    <!---- Feature - Start ---->
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label>Existing Photo</label>
                                            <div>
                                                <img src="{{ $home_page_items->feature_background ? asset('uploads/home-page-item/'.$home_page_items->feature_background) : asset('uploads/no-img.png') }}" alt="" style="width:100%;" class="w_200">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Change Photo</label>
                                                <input type="file" name="feature_background" id="feature_background" class="form-control">
                                                @error('feature_background')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">                                        
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select name="feature_status" id="feature_status" class="form-control">
                                                    <option value="show" @if($home_page_items->feature_status == "show") selected @endif>Show</option>
                                                    <option value="hide" @if($home_page_items->feature_status == "hide") selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Feature - End ---->
                                </div>
                                <div class="tab-pane fade" id="nav-event" role="tabpanel" aria-labelledby="nav-event-tab" tabindex="0">
                                    <!---- Event - Start ---->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Heading</label>
                                                <input type="text" name="event_heading" id="event_heading" value="{{ $home_page_items->event_heading }}" class="form-control">
                                                @error('event_heading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Sub Heading</label>
                                                <input type="text" name="event_subheading" id="event_subheading" value="{{ $home_page_items->event_subheading }}" class="form-control">
                                                @error('event_subheading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select name="event_status" id="event_status" class="form-control">
                                                    <option value="show" @if($home_page_items->event_status == "show") selected @endif>Show</option>
                                                    <option value="hide" @if($home_page_items->event_status == "hide") selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Event - End ---->
                                </div>
                                <div class="tab-pane fade" id="nav-testimonial" role="tabpanel" aria-labelledby="nav-testimonial-tab" tabindex="0">
                                    <!---- Testimonial - Start ---->
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label>Existing Photo</label>
                                            <div>
                                                <img src="{{ $home_page_items->testimonial_background ? asset('uploads/home-page-item/'.$home_page_items->testimonial_background) : asset('uploads/no-img.png') }}" alt="" style="width:100%;" class="w_200">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Change Photo</label>
                                                <input type="file" name="testimonial_background" id="testimonial_background" class="form-control">
                                                @error('testimonial_background')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Heading</label>
                                                <input type="text" name="testimonial_heading" id="testimonial_heading" value="{{ $home_page_items->testimonial_heading }}" class="form-control">
                                                @error('testimonial_heading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select name="testimonial_status" id="testimonial_status" class="form-control">
                                                    <option value="show" @if($home_page_items->testimonial_status == "show") selected @endif>Show</option>
                                                    <option value="hide" @if($home_page_items->testimonial_status == "hide") selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Testimonial - End ---->
                                    
                                </div>
                                <div class="tab-pane fade" id="nav-blog" role="tabpanel" aria-labelledby="nav-blog-tab" tabindex="0">
                                    <!---- Blog - Start ---->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Heading</label>
                                                <input type="text" name="blog_heading" id="blog_heading" value="{{ $home_page_items->blog_heading }}" class="form-control">
                                                @error('blog_heading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Sub Heading</label>
                                                <input type="text" name="blog_subheading" id="blog_subheading" value="{{ $home_page_items->blog_subheading }}" class="form-control">
                                                @error('blog_subheading')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select name="blog_status" id="blog_status" class="form-control">
                                                    <option value="show" @if($home_page_items->blog_status == "show") selected @endif>Show</option>
                                                    <option value="hide" @if($home_page_items->blog_status == "hide") selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Blog - End ---->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Feature Section -->
                {{-- <div class="col-sm-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5>Feature Section</h5>
                            
                        </div>
                    </div>
                </div> --}}
                
                <!-- Testimonial Section -->
                {{-- <div class="col-sm-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5>Testimonial Section</h5>
                            
                        </div>
                    </div>
                </div> --}}
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>            
        </form>
    </div>
</section>
@endsection
