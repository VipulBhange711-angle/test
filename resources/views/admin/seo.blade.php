@extends('admin.layouts.main')
@section('content')

        <div class="content-page">
            <div class="content">
 
                <!-- Start Content-->
                <div class="container-fluid jobseeker-view-page">

                    @include('admin.layouts.breadcrumb')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header jobseeker-header">
                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button" href="{{route('seo-page-edit')}}">
                                            <i class="bi bi-person-plus-fill"></i> Add Page
                                        </a>
                                        
                                        <a class="btn btn-primary main-button" role="button" 
                                            data-bs-toggle="modal" data-bs-target="#delete-selected-modal">
                                            <i class="ri-delete-bin-fill"></i> Delete 
                                        </a>
<!-- 
                                        <a class="btn btn-primary main-button" role="button"
                                            data-bs-toggle="modal" data-bs-target="#approve-modal">
                                            <i class="ri-user-follow-line"></i> Approve 
                                        </a>
                                        <a class="btn btn-primary main-button" role="button"
                                            data-bs-toggle="modal" data-bs-target="#reject-modal">
                                            <i class="ri-close-circle-fill"></i> Reject 
                                        </a> -->

                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;"> <i class="ri-file-excel-2-fill"></i> Export 
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Import</a>
                                                <a class="dropdown-item" href="{{route('page-export')}}">Export</a>
                                            </div>
                                        </div>
<!-- 
                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;"> <i class="ri-filter-2-fill"></i> Filter 
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Approved</a>
                                                <a class="dropdown-item" href="#">Rejected</a>
                                            </div>
                                        </div> -->
                                        
                                        
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <!-- <table id="alternative-page-datatable" -->
                                    <table id="" class="table table-striped dt-responsive nowrap w-100 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;" class="check-box-1"><div class="form-check "> <input type="checkbox" class="form-check-input" id="customCheckcolor1" > </div>
                                                </th>
                                                <th style="width: 40px;">Sr. No.</th>
                                                <th>Page Name</th>
                                                <th>Slug</th>
                                                <th>Keywords</th>
                                                <th>H1 Tag</th>
                                                <th>Title</th>
                                                <th>Meta Discription</th>
                                                <th>Meta Tags</th>
                                                <th>Page Url</th>
                                                <th>Status</th>
                                                 <th>Updated by</th>
                                                <th>Last Update</th>
                                                <th>Created On</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($pagesData as $data)
                                                
                                       
                                            <tr>
                                                 <td class="check-box-1"><div class="form-check"> 
                                                    <form class="actionId">
                                                    <input type="checkbox" class="form-check-input" value="{{base64_encode($data->id)}}" name="userId[]" id="{{'customCheckcolor'.$i}}" >
                                                      </form></td>
                                                <td>{{$i}}</td>    
                                                <td>{{$data->page_name}}</td>
                                                <td>{{$data->slug}}</td>
                                                <td>{{$data->keywords}}</td>
                                                <td>{{$data->h1_tag}}</td>
                                                <td>{{$data->page_title}}</td>
                                                <td>{{$data->page_content}}</td>
                                                <td>{{$data->meta_tags}}</td>
                                                <td>{{$data->page_url}}</td>
                                                <td><span class="badge bg-primary rounded-pill">{{$data->page_status}}</span></td>
                                                <td>{{$data->fullname}}</td>
                                                <td>{{$data->last_update}}</td>
                                                <td>{{$data->created_on}}</td>
                                                <td>
                                                    <a href="{{route('seo-page-view',base64_encode($data->id))}}" class="text-reset fs-16 px-1"> 
                                                        <i class="bi bi-eye-fill"></i></a>
                                                    <a href="{{route('seo-page-update',base64_encode($data->id))}}" class="text-reset fs-16 px-1"> 
                                                        <i class="mdi mdi-pencil"></i></a>
                                                    {{-- <a href="javascript: void(0);" class="text-reset fs-16 px-1"> 
                                                        <i class="ri-delete-bin-2-line" data-bs-toggle="modal" data-bs-target="#delete-single-modal"></i></a> --}}
                                                </td>

                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
     @endforeach

                                        </tbody>
                                    </table>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->

                     <!-- Add Jobseeker modal content -->
                     <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">

                             <div class="modal-header">
                                 <h4 class="modal-title" id="topModalLabel">Add Jobseeker</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                                     aria-label="Close"></button>
                             </div>

                             <div class="modal-body">

                                 <form class="ps-3 pe-3" action="#">

                                     <div class="mb-3">
                                         <label for="username" class="form-label">Full Name</label>
                                         <input class="form-control" type="email" id="username"
                                             required="" placeholder="Michael Zenaty">
                                     </div>

                                     <div class="mb-3">
                                         <label for="emailaddress" class="form-label">Email Address</label>
                                         <input class="form-control" type="email" id="emailaddress"
                                             required="" placeholder="john@deo.com">
                                     </div>

                                     <div class="mb-3">
                                         <label for="mobile-number" class="form-label">Mobile Number</label>
                                         <div class="input-group">
                                            <select id="inputState" class="form-select" style="padding: 5px 0px 5px 5px;">
                                                <option>+91</option>
                                                <option>+356</option>
                                                <option>+54</option>
                                                <option>+78</option>
                                            </select>
                                            <input class="form-control" type="email" id="emailaddress"
                                             required="" placeholder="+1234567890" style="width: 50%;">
                                        </div>
                                     </div>

                                     <div class="mb-3">
                                         <label for="password" class="form-label">Password</label>
                                         <input class="form-control" type="password" required=""
                                             id="password" placeholder="Enter Password">
                                     </div>


                                 </form>

                             </div>

                             <div class="modal-footer">
                                 
                                 <button type="button" class="btn btn-primary">Add</button>
                                 <button type="button" class="btn btn-light"
                                     data-bs-dismiss="modal">Close</button>
                             </div>

                         </div><!-- /.modal-content -->
                     </div><!-- /.modal-dialog -->
                 </div><!-- /.modal -->


                 <!-- Delete manually Modal  -->
                <div id="delete-selected-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-2">
                            <div style="float: right;">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                               <div class="text-center">
                            <i class="ri-information-line h1 text-info"></i>
                            <h4 class="mt-2">Delete record?</h4>
                            <p class="mt-3"> Are you sure ?</p>
                            <button type="button" class="btn btn-info my-2 deletePage">Delete</button>
                            <button type="button" class="btn btn-light"
                                    data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->            


        <!-- Approve Modal  -->
        <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div style="float: right;">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="text-center">
                        <i class="ri-information-line h1 text-info"></i>
                        <h4 class="mt-2">Approve records?</h4>
                        <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->   
    
    
    <!-- Reject Modal  -->
    <div id="reject-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div style="float: right;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="text-center">
                    <i class="ri-information-line h1 text-info"></i>
                    <h4 class="mt-2">Reject records?</h4>
                    <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
                    <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->                


                </div> <!-- container -->

            </div> <!-- content -->


        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
@endsection