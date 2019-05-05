<style>
.widget-user .widget-user-header{
    height: 250px !important;
}
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-11">
               <!-- dhfjsdhfj -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background: url('./img/photo1.png') center center;">
                <h3 class="widget-user-username">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
               <!-- sjhdashdj -->
            </div>
            <div class="col-md-11">
                <!-- sdjasjd -->

               
                <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">

                    <div class="tab-pane active show" id="settings">
                        <form class="">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>

                            <div class="">
                            <input type="text" v-model="form.name" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                             id="name" name="name" placeholder="Name">
                             <has-error :form="form" field="name"></has-error>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class=" control-label">Email</label>

                            <div class="">
                            <input type="email"  :class="{ 'is-invalid': form.errors.has('email') }" 
                            v-model="form.email" 
                            class="form-control" id="email" name="email" placeholder="Email">
                            <has-error :form="form" field="email"></has-error>

                            </div> 
                        </div>
                       
                        <div class="form-group">
                            <label for="bio" class=" control-label">Bio</label>

                            <div class="">
                            <textarea class="form-control"  v-model="form.bio" id="bio" name="Write something" placeholder="Experience"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="photo" class=" control-label">Profile Photo</label>

                            <div class="">
                                <input type="file" @change="updateProfile" class="form-control" id="photo" name="photo" placeholder="Photo">
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="password"  class=" control-label">
                                    Password (leave empty if not changing)

                                </label>
    
                                <div class="">
                                <input type="text" v-model="form.password" 
                                :class="{ 'is-invalid': form.errors.has('password') }"
                                class="form-control" id="password" name="password" 
                                placeholder="Passport">
                                <has-error :form="form" field="password"></has-error>
                                </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="">
                            <button  @click.prevent="updateInfo" type="button" class="btn btn-success">Update</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          
                <!-- sdjashd -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form:new Form({
                    id : '',
                    name:'',
                    email:'',
                    password:'',
                    type:'',             
                    bio:'',                
                    photo:'',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            updateProfile(e) {
                let file    = e.target.files[0]; //sames as here
                let reader  = new FileReader();
                let limit = 1024 * 3;
                if (file['size'] < limit) {
                    Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Image size is large please upload image of 2MB',
                    })
                } else {
                    reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
                
            },
            updateInfo() {
                this.$Progress.start();
                this.form.put('api/profile')
                .then(() => {
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            }
        },
        created() {
            axios.get('api/profile').
            then((response) => this.form.fill(response.data))
            .catch(() => {
                console.log("Sorry unable to get the user data");
            })
        }
    }
</script>
