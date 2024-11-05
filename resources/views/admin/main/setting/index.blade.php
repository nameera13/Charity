@extends('admin.layout.default')
@section('title','Admin Setting')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>{{ $module_name }}</h1>
    </div>
    <div class="section-body">
        <form action="{{ url('admin/setting') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row d-flex align-items-stretch">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">                        
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-logo-fav-ban-tab" data-bs-toggle="tab" data-bs-target="#nav-logo-fav-ban" type="button" role="tab" aria-controls="nav-logo-fav-ban" aria-selected="true">Logo, Favicon, Banner</button>
                                <button class="nav-link" id="nav-top-bar-tab" data-bs-toggle="tab" data-bs-target="#nav-top-bar" type="button" role="tab" aria-controls="nav-top-bar" aria-selected="false">Top Bar</button>
                                <button class="nav-link" id="nav-cta-tab" data-bs-toggle="tab" data-bs-target="#nav-cta" type="button" role="tab" aria-controls="nav-cta" aria-selected="false">CTA</button>
                                <button class="nav-link" id="nav-footer-tab" data-bs-toggle="tab" data-bs-target="#nav-footer" type="button" role="tab" aria-controls="nav-footer" aria-selected="false">Footer</button>
                                <button class="nav-link" id="nav-map-tab" data-bs-toggle="tab" data-bs-target="#nav-map" type="button" role="tab" aria-controls="nav-map" aria-selected="false">Map</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-logo-fav-ban" role="tabpanel"aria-labelledby="nav-logo-fav-ban-tab" tabindex="0">
                                    <!---- Logo, Favicon, Banner - Start ---->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label>Existing Logo</label>
                                                <div>
                                                    <img src="{{ $setting->logo ? asset('uploads/setting/'.$setting->logo) : asset('uploads/no-img.png') }}" alt="" style="width:100%;" class="w_200">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Change Logo</label>
                                                <input type="file" name="logo" id="logo" class="form-control">
                                                @error('logo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label>Existing Favicon</label>
                                                <div>
                                                    <img src="{{ $setting->favicon ? asset('uploads/setting/'.$setting->favicon) : asset('uploads/no-img.png') }}" alt="" style="width:100%;" class="w_200">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Change Favicon</label>
                                                <input type="file" name="favicon" id="favicon" class="form-control">
                                                @error('favicon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label>Existing Banner</label>
                                                <div>
                                                    <img src="{{ $setting->banner ? asset('uploads/setting/'.$setting->banner) : asset('uploads/no-img.png') }}" alt="" style="width:100%;" class="w_200">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Change Banner</label>
                                                <input type="file" name="banner" id="banner" class="form-control">
                                                @error('banner')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Logo, Favicon, Banner - End ---->
                                </div>
                                <div class="tab-pane fade" id="nav-top-bar" role="tabpanel" aria-labelledby="nav-top-bar-tab" tabindex="0">
                                    <!---- Top Bar - Start ---->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Phone</label>
                                                <input type="text" name="top_phone" id="top_phone" value="{{ $setting->top_phone }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Email</label>
                                                <input type="text" name="top_email" id="top_email" value="{{ $setting->top_email }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Top Bar - End ---->
                                </div>
                                <div class="tab-pane fade" id="nav-cta" role="tabpanel" aria-labelledby="nav-cta-tab" tabindex="0">
                                    <!---- CTA - Start ---->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>Heading</label>
                                                <input type="text" name="cta_heading" id="cta_heading" value="{{ $setting->cta_heading }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>Text</label>
                                                <textarea name="cta_text" class="form-control h_100" cols="30" rows="10">{{ $setting->cta_text }}</textarea>            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Button Text</label>
                                                <input type="text" name="cta_button_text" id="cta_button_text" value="{{ $setting->cta_button_text }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Button URL</label>
                                                <input type="text" name="cta_button_url" id="cta_button_url" value="{{ $setting->cta_button_url }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <select name="cta_status" id="cta_status" class="form-control">
                                                    <option value="show" @if($setting->cta_status == "show") selected @endif>Show</option>
                                                    <option value="hide" @if($setting->cta_status == "hide") selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- CTA - End ---->
                                </div>
                                <div class="tab-pane fade" id="nav-footer" role="tabpanel" aria-labelledby="nav-footer-tab" tabindex="0">
                                    <!---- Footer - Start ---->                                   
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Address</label>
                                                <input type="text" name="footer_address" id="footer_address" value="{{ $setting->footer_address }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Phone</label>
                                                <input type="text" name="footer_phone" id="footer_phone" value="{{ $setting->footer_phone }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Email</label>
                                                <input type="text" name="footer_email" id="footer_email" value="{{ $setting->footer_email }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Facebook</label>
                                                <input type="text" name="facebook" id="facebook" value="{{ $setting->facebook }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Twitter</label>
                                                <input type="text" name="twitter" id="twitter" value="{{ $setting->twitter }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Youtube</label>
                                                <input type="text" name="youtube" id="youtube" value="{{ $setting->youtube }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Linkedin</label>
                                                <input type="text" name="linkedin" id="linkedin" value="{{ $setting->linkedin }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label>Instagram</label>
                                                <input type="text" name="instagram" id="instagram" value="{{ $setting->instagram }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>Copyright</label>
                                                <input type="text" name="copyright" id="copyright" value="{{ $setting->copyright }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Footer - End ---->                                    
                                </div>
                                <div class="tab-pane fade" id="nav-map" role="tabpanel" aria-labelledby="nav-map-tab" tabindex="0">
                                    <!---- Map - Start ---->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>Map(iFrame Code)</label>
                                                <textarea name="map" class="form-control h_100" cols="30" rows="10">{{ $setting->map }}</textarea>            
                                            </div>
                                        </div>
                                    </div>
                                    <!---- Map - End ---->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>            
        </form>
    </div>
</section>
@endsection
