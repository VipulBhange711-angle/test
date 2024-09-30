@extends('admin.layouts.main')
@section('content')

        <div class="content-page jobseeker-edit-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                         @include('admin.layouts.breadcrumb')


                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{route('add-template')}}" method="POST">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="  col-md-4">
                                                <label for="inputAddress" class="form-label">Select Type</label>
                                                <select class="form-control" name="type">
                                                    <option value="1">Employer</option>
                                                    <option value="2">Jobseeker</option>
                                                    <option value="0">Common</option>
                                                </select>
                                              @error('type')
                                                <span style="color:red;text-transform:capitalize">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="  col-md-4">
                                                <label for="inputAddress" class="form-label">Template Name</label>
                                                <input type="text" class="form-control" id="inputAddress"
                                                    placeholder="" name="template_name" value="{{  old('template_name')}}">
                                              @error('template_name')
                                                <span style="color:red;text-transform:capitalize">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputAddress" class="form-label">Email Subject</label>
                                                <input type="text" class="form-control" id="inputAddress"
                                                    placeholder="" name="email_subject" value="{{  old('email_subject')}}">
                                                    @error('email_subject')
                                                <span style="color:red;text-transform:capitalize">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="inputAddress" class="form-label">Email Content</label>
                                                <textarea type="text" class="form-control" id="inputAddress" name="email_content"> {{  old('template_name')}}</textarea>
                                                @error('email_content')
                                                <span style="color:red;text-transform:capitalize;">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>
                                        
                                </div> <!-- end card-body -->
                          
                            </div> <!-- end card-->
                        <button type="submit" class="btn btn-primary mb-4 me-2">Add</button>
                       <a href="{{route('email-view')}}"> <button type="button" class="btn btn-secondary mb-4">Back</button></a>
                                    </form>
                        </div> <!-- end col -->
                    </div>


                

                   
                </div> <!-- container -->

            </div> <!-- content -->


        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
      <script>
CKEDITOR.replace('email_content');
</script>
    <!-- END wrapper -->
@endsection