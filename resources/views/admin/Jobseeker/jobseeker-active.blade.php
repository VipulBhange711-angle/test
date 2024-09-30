@extends('layouts.main')
@section('content')

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid jobseeker-view-page">

                 @include('layouts.breadcrumb')
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header jobseeker-header">
                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button"
                                            data-bs-toggle="modal" data-bs-target="#signup-modal">
                                            <i class="bi bi-person-plus-fill"></i> Add 
                                        </a>
                                        
                                        <a class="btn btn-primary main-button" role="button"
                                            data-bs-toggle="modal" data-bs-target="#delete-selected-modal">
                                            <i class="ri-delete-bin-fill"></i> Delete 
                                        </a>

                                        <a class="btn btn-primary main-button" role="button"
                                            data-bs-toggle="modal" data-bs-target="#approve-modal">
                                            <i class="ri-user-follow-line"></i> Approve 
                                        </a>
                                        <a class="btn btn-primary main-button" role="button"
                                            data-bs-toggle="modal" data-bs-target="#reject-modal">
                                            <i class="ri-close-circle-fill"></i> Reject 
                                        </a>

                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;"> <i class="ri-file-excel-2-fill"></i> Excel 
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Import</a>
                                                <a class="dropdown-item" href="#">Export</a>
                                            </div>
                                        </div>

                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;"> <i class="ri-filter-2-fill"></i> Filter 
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Approved</a>
                                                <a class="dropdown-item" href="#">Rejected</a>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <!-- <table id="alternative-page-datatable" -->
                                    <table id="" class="table table-striped dt-responsive nowrap w-100 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;" class="check-box-1"><div class="form-check "> <input type="checkbox" class="form-check-input" id="customCheckcolor1" > </div></th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Plan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <tr>
                                                <td class="check-box-1"><div class="form-check"> 
                                                    <input type="checkbox" class="form-check-input " id="customCheckcolor1" > </div></td>
                                                <td class="jobseeker-profile-photo">
                                                        <img src="{{ asset('admin/assets/images/users/avatar-1.jpg')}}" alt=""></td>
                                                <td>Haresh Gurav</td>
                                                <td>haresh@angel-portal.com</td>
                                                <td>1234567890</td>
                                                <td><i class="ri-shield-star-fill"></i> Active</td>
                                                <td><i class="ri-user-follow-line"></i> Pending</td>
                                                <td>
                                                    <a href="jobseeker-view.php" class="text-reset fs-16 px-1"> 
                                                        <i class="bi bi-eye-fill" ></i></a>
                                                    <a href="jobseeker-edit.php" class="text-reset fs-16 px-1"> 
                                                        <i class="mdi mdi-pencil" ></i></a>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1"> 
                                                        <i class="ri-delete-bin-2-line" data-bs-toggle="modal" data-bs-target="#delete-single-modal"></i></a>
                                                
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1"> 
                                                        <i class="ri-checkbox-fill" data-bs-toggle="modal" data-bs-target="#active-to-paid-modal"></i></a>
                                                </td>

                                            </tr>


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
                                <h5 class="mt-2">Delete records?</h5>
                                <p class="mt-3">Are you sure you want to delete this records?</p>
                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal">Delete</button>
                                <button type="button" class="btn btn-light"
                                     data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->            

                <!-- Delete Single Modal  -->
            <div id="delete-single-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p class="mt-3">Are you sure you want to delete this record?</p>
                            <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal">Delete</button>
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
                        <p class="mt-3">Are you sure you want to approve this record?</p>
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
                    <p class="mt-3">Are you sure you want to approve this record?</p>
                    <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->      



                     <!-- Approve Jobseeker modal content -->
                     <div id="active-to-paid-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">

                             <div class="modal-header">
                                 <h4 class="modal-title" id="topModalLabel">Active to Paid</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                                     aria-label="Close"></button>
                             </div>

                             <div class="modal-body">

                                 <form class="ps-3 pe-3" action="#">

                                     <div class="mb-3">
                                         <label for="username" class="form-label">Plan Duration</label>
                                         <select id="inputState" class="form-select" style="padding: 5px 0px 5px 5px;">
                                                <option>Select</option>
                                                <option>90 Days</option>
                                                <option>180 Days</option>
                                                
                                            </select>
                                     </div>

                                     <div class="mb-3">
                                         <label for="PlanCost" class="form-label">Plan Cost</label>
                                         <input class="form-control" type="text" id="PlanCost"
                                             required="" placeholder="Plan Cost" value="EUR 40/-">
                                     </div>

                                     <div class="mb-3">
                                         <label for="username" class="form-label">Payment Mode</label>
                                         <select id="inputState" class="form-select" style="padding: 5px 0px 5px 5px;">
                                                <option>Select</option>
                                                <option>Cash</option>
                                                <option>Credit Card</option>
                                                <option>Debit Card</option>
                                                <option>Other</option>
                                                
                                            </select>
                                     </div>

                                     <div class="mb-3">
                                         <label for="PaymentNote" class="form-label">Payment Note:</label>
                                         <textarea class="form-control" id="example-textarea" rows="5" spellcheck="false"></textarea>
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




                </div> <!-- container -->

            </div> <!-- content -->


        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
@endsection