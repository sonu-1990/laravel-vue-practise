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
                       @click="addModal">Add New
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
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                        <tr v-if="users" v-for="(user, index) in users" :key="user.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.type | capitalize}}</td>
                            <td>{{ user.created_at | dateFormat }}</td>
                            <td>
                                <a href="#" @click="editModal(user)">
                                    <i class="fa fa-edit"></i>
                                </a> /
                                <a href="#" @click="deleteUser(user.id)">
                                    <i class="fa fa-trash text text-danger"></i>
                                </a>
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
                        <h5 v-show="!editMode" class="modal-title" id="addNewModalLongTitle">
                            Add New
                        </h5>
                        <h5 v-show="editMode" class="modal-title" id="addNewModalLongTitle">
                            Update User Info
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form @submit.prevent="editMode ? updateUser() : createUser() ;">
                            <div class="modal-body">
                            <!-- User Form Start -->
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                    placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
        
                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email"
                                    placeholder="Email Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
        
                            <div class="form-group">
                                <textarea v-model="form.bio" name="bio" id="bio"
                                placeholder="Short bio for user (Optional)"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>
        
        
                            <div class="form-group">
                                <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
        
                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" id="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
        
                            <!-- User Form End -->
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">
                                Create
                            </button>
                            <button v-show="editMode" type="submit" class="btn btn-success">
                                Update
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal end -->
    </div>

</template>

<script>
    export default {
        data() {
            return {
                users: {}, 
                loading: false,
                editMode: false,
                form:new Form({
                    id : '',
                    name:'',
                    email:'',
                    password:'',
                    type:'',
                    bio:'',
                    photo:''
                })
            }
        },
        methods: {
            updateUser() {
                this.form.put('api/users/'+ this.form.id)
                .then(() => {
                    this.$Progress.start()
                    Fire.$emit('AfterCreate');
                    Swal.fire(
                    'Updated',
                    'User updated successfully.',
                    'success'
                    )
                    $('#addNewModalCenter').modal('hide');
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            addModal() {
                this.editMode = false;
                this.form.reset()
                $('#addNewModalCenter').modal('show');
            },
            editModal(user) {
                this.editMode = true;
                this.form.fill(user);
                $('#addNewModalCenter').modal('show');
            },
            loadUsers() {
                this.$Progress.start()
                axios.get('/api/users')
                .then((response) => {
                    this.users = response.data.data
                    this.$Progress.finish()
                })
                .catch((error) => {
                    this.$Progress.fail()
                })
            },
            createUser() {
                this.$Progress.start()
                this.form.post('api/users')
                .then(() => {
                    Fire.$emit('AfterCreate');
                    Toast.fire({
                        type: 'success',
                        title: 'User Created successfully!'
                    })
                    $('#addNewModalCenter').modal('hide');
                    this.$Progress.finish()
                }).catch(() => {

                })
            },
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    
                    if (result.value) {
                        this.form.delete('api/users/'+id)
                        .then(() => {
                            Fire.$emit('AfterCreate')
                            Swal.fire(
                            'Deleted!',
                            'User deleted successfully.',
                            'success'
                            )
                        }).catch(() => {
                            
                        })
                    }
                })
            }
        },
        
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
                this.loadUsers(); 
            });
            // setInterval(() => {
            //     this.loadUsers();
            // }, 3000);
        }
    }
</script>
