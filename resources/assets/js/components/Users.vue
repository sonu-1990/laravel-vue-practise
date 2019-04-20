<template>
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header p-5">
                        <h3 class="card-title">Users Table</h3>
        
                        <div class="card-tools">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success mt-4" 
                        data-toggle="modal" data-target="#addNewModalCenter">Add New
                            <i class="fa fa-user-plus"></i>
                        </button>
    
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>175</td>
                            <td>Mike Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-danger">Denied</span></td>
                            <td>
                                <a href="#">
                                    <i class="fa fa-edit"></i>
                                </a> /
                                <a href="#"><i class="fa fa-trash text text-danger"></i></a>
                            </td>
                        </tr>
                        </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addNewModalCenter" tabindex="-1" role="dialog" aria-labelledby="addNewModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="addNewModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        text
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal end -->
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
