1 > composer create-project --prefer-dist laravel/laravel laravel-vue-practise
2 > npm install
3 > npm install admin-lte@versionname --save
npm install admin-lte@v3.0.0-alpha.2 --save
4 > php artisan make:auth
5 > php artisan migrate
You will get - Syntax error or access violation: 1071 Specified key was too long; max key
  length is 767 bytes
Go to AppServiceProvider
public function boot()
    {
        Schema::defaultStringLength(191);
    }
    use Illuminate\Support\Facades\Schema;
6 > php artisan migrate:fresh
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<script src="{{ asset('js/app.js') }}"></script>
by default app.blade.php is the main file from which home.blade.php is created
7 > Go to resources/assets/js/bootstrap.js
Add:  
require('admin-lte');
8 > Go to resources/assets/sass/app.scss
Add:
@import "~admin-lte/dist/css/adminlte.css";
9 > npm run watch (resourses css / js is compiled to public css / js)
10 > Go to https://www.flaticon.com/ 
Then save images (profile and logo to public/img/)
11 > https://fontawesome.com/start then scroll page and go to sass
npm install --save-dev @fortawesome/fontawesome-free

in app.scss (Refer to the font and svg icon)
$fa-font-path:"../webfonts"; 
@import "~@fortawesome/fontawesome-free/scss/fontawesome.scss";
@import "~@fortawesome/fontawesome-free/scss/solid.scss";
@import "~@fortawesome/fontawesome-free/scss/brands.scss";

12 > Change profile and logo on master.blade.php 
(We have used admin-lte index source code to make master.blade.php)
13 > font awesome icon is not working so go to matser.blade.php and add proper font awesome icon
14 > change font awesome icon on master.blade.php
15 > npm install vue-router
16 > Go to resources/asset/js/app.js
17 > import below above vue instance
import VueRouter from 'vue-router'
Vue.use(VueRouter)

configure vue 
const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/profile', component: require('./components/Profile.vue')}
]
const router = new VueRouter({
    routes // short for `routes: routes`
})
add above route 
const app = new Vue({
    el: '#app',
    router
});
18 > If you want to access url without # then you need to add 
mode: 'history' in
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

because of history mode we are able to access url without # symbol
but when we enter to the url in it gives error beacuse after removing hash symobol
it consider as a laravel route but laravel web.php is't have route like as we have 
entered so we need to add above line 
Route::get('{path}', 'HomeController@index')->name('path', '([A-Za-z\d-\/_.]+)?');

19 > Now if we want to show active link then you should write some css 
with the help of active class of link.

20 > If we want to write css for anything we can write it in variable.scss
21 > Create user component then go to admin-lte index page and copy responsive
table and paste into the user component make some changes and add new 
button for creating new user as well as add new bootstrap modal 
21 > npm i axios vform (for laravel backend validation)
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
22 > Add form to laravel user modal and then
data() {
    return {
        form:new Form({
            name:'',
            email:'',
            password:'',
            type:'',
            bio:'',
            photo:''
        })
    }
},
and send requst as this.form.post('users')
where form is like 
<form @submit.prevent="createUser"> where createUser is the method
include route in api.php
23 > Include model in controller and for password include hash as well
use App\User;
use Hash; 
and then return create user as
return User::create([
    'name' => $request['name'],
    'email' => $request['email'],
    'type' => $request['type'],
    'bio' => $request['bio'],
    'photo' => $request['photo'],
    'password' => Hash::make($request['password'])
]);

24 > For laravel backend validation we need to write
$this->validate($request,
[
    'name' => 'required|string|max:191',
    'email' => 'required|string:email:max:191|unique:users',
    'password' => 'required|string|min:6',
    'type' => 'required'
]
);
This will automatically reflect the errors on form because we use vue form
then if you want to load all the data in database then you need to create 
function in 
created / mounted of vue.js component
such as 
loadUsers() {
    axios.get('/api/users')
    .then((response) => {
        this.users = response.data.data
    })
    .catch(() => {
    })
},

we can call the same method loadUsers() from created
so that whenever page is loaded all the data will get 

if you want to show all the data then first check data have something in it with 
the help of v-if 
and then use v-for="(user, index) in users" :key="user.id" note index should be 
the next param 

23 > For custom filter we can create filter by the following way.
Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

24 > For date formatting we are going to use moment.js
npm install moment --save

Vue.filter('dateFormat', function(created_at) {
    return moment(created_at).format('MMMM Do YYYY');
})

25 > npm install vue-progressbar --save
for showing progressbar when data is saved or updated or deleted.

in app.js
import VueProgressBar from 'vue-progressbar'

let options = {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '80px'
}
Vue.use(VueProgressBar, options)
Vue.use(VueProgressBar, options)

in master.blade.php
<vue-progress-bar></vue-progress-bar>

26 > npm install sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast

Toast.fire({
        type: 'success',
        title: 'User Created successfully!'
})
$('#addNewModalCenter').modal('hide');

27 > For getting the updated info all the time we used 
setInterval(() => {
    this.loadUsers()
}, 3000)

asked for the data after every 3 seconds.

28 > It is not a good idea to send request every after 3 seconds
if user is not doing anything so instead of sending request 
after every 3 seconds we will use Fire (Vue js custom event)
window.Fire = new Vue()

Fire.$emit('afterUserCreated') "Hey I am throwing something."

this.form.post('api/users')
.then(() => {
    Fire.$emit('AfterCreate');
}).catch(() => { }

created() {
    this.loadUsers();
    "Hey I am catching"
    Fire.$on('AfterCreate', () => {
        this.loadUsers(); 
    });
    // setInterval(() => {
    //     this.loadUsers();
    // }, 3000);
}

29 > For deleting record we need to send delete request,
such as
this.form.delete('api/users/'+id) //Look at this- this.form.delete
.then(() => {
    Fire.$emit('AfterCreate')
    Swal.fire(
    'Deleted!',
    'User deleted successfully.',
    'success'
    )
}).catch(() => {
    
})

30 > You can use same modal for edit and update just by calling
when edit send complete user object to modal
when add just clear the vus js form .
addModal() {
    this.form.reset()
    $('#addNewModalCenter').modal('show');
},
editModal(user) {
    this.form.fill(user);
    $('#addNewModalCenter').modal('show');
},

31 > Conditionally call update and add action.
@submit.prevent="editMode ? updateUser() : createUser() ;"
edit mode true means edit the data else create the data 

and when we close and open the modal just change the value of
editMode

3 > For updating info we need to use put method of vue form
then
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

* > Laravel passport authentication
1. composer require laravel/passport "4.0.3"
Or composer require laravel/passport based on laravel as well as php version.
2. php artisan vendor:publish --tag=passport-migrations
3. php artisan migrate
4. php artisan passport:install


* > For securing our api from unauthorized user
just follow the link on laravel documentation
https://laravel.com/docs/5.5/passport#consuming-your-api-with-javascript

* >Important note when using images in public folder as a background image
in vue component then you can not use asset with src attribute of image 
it gives you an error as src is not an attribute 
but in case of background color you must use url()
function such as 

if your component in resources/js/components
then use in one of the component as 
url('./img/photo1') <- where img is public/img




