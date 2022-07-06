<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <!-- axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Vue2</title>
</head>
<body>
<style>
    .test{
        color: red;
    }
    .test1{
        border: solid 1px red;
    }
    .empty{
        border: solid 1px red;
    }
</style>

    <div id="app">
        <div class="card mt-1 ml-1 mr-1">
            <div class="card-header">
                <h5>Vue2 Form Validation</h5>
            </div>
            <div class="card-body">
                <form @submit="checkForm" novalidate="true">
                <div class="row">
                    <!-- errors -->
                    <div class="col-lg-12">
                        <span v-if="errors.length">
                            <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                        </span>
                    </div>

                    <!-- name -->
                    <div class="col-lg-6">
                        <label for="name">Name</label>
                        <input id="name" v-model="formData.name" type="text"  name="name" class="form-control" :class="{empty: emptyName}">

                    </div>

                    <!-- email -->
                    <div class="col-lg-6">
                        <label for="name">Email</label>
                        <input id="email" v-model="email"type="email" name="email" class="form-control" :class="{empty: emptyEmail}">

                    </div>

                    <!-- Favourite movie -->
                    <div class="col-lg-6">
                        <label for="movie">Favorite Movie</label>
                        <select id="movie"  v-model="movie"  name="movie" class="form-control" :class="{empty: emptyMovie}" @change="updateMovie">
                            <option>Star Wars</option>
                            <option>Vanilla Sky</option>
                            <option>Atomic Blonde</option>
                        </select>
                    </div>

                    <div class="col-lg-12 mt-2">
                        <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
                </div><!-- /row -->


                </form>
            </div><!-- /card-body -->
        </div><!-- /card -->




    </div><!-- /app -->




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
<!--------------------------------- end of  html ------------------------------------------------>
<script>
const app = new Vue({
el: '#app',
data: {
errors: [],

    formData: {},
name: null,
email: null,
movie: null,
    emptyName: false,
    test: true,
    test1: true,
    emptyEmail: false,
    emptyMovie: false,
    message: 'Vue 2',
},
methods: {

checkForm: function (e) {
    this.emptyName = false;
    this.emptyEmail = false;
    this.emptyMovie = false;
this.errors = [];
    if (!this.formData.name) {
        this.errors.push("Name required.");
        this.emptyName = true;

    }else{
        console.log('form data not empty');
        console.log(this.formData.name);
        console.log(this.formData);

        //this.formData['name'] = this.name;
    }

// if (!this.name) {
// this.errors.push("Name required.");
// this.emptyName = true;
//
// }else{
//     console.log('form data');
//     console.log(this.formData);
//
//     //this.formData['name'] = this.name;
// }

    if (!this.movie) {
        this.errors.push("Select Movie.");
        this.emptyMovie = true;

    }else if(this.movie === 'Star Wars') {
        this.errors.push("Star wars not allowed");
        this.emptyMovie = true;
    }else{
        this.formData['movie'] = this.movie;

    }




if (!this.email) {
 this.emptyEmail = true;
this.errors.push('Email required.');
} else if (!this.validEmail(this.email)) {
this.errors.push('Valid email required.');
}else{

   this.formData['email'] = this.email;

}

if (!this.errors.length) {
    console.log('formdata');
    console.log(this.formData);
    console.log('ready to submit form ');
    var objData = JSON.stringify(this.formData);
   // var objData = this.formData;
    console.log('objData');
    console.log(objData);
    axios.post("<?= $webroot; ?>en_US/SetupPages/submitForm",objData).then(function(response){
        if(response){
            console.log('submit success');
            app.data = response.data;
            console.log('data');
            console.log(data);

        }

    });
//return true;
}

e.preventDefault();
},
    updateMovie: function(){
        this.emptyMovie = false;

    },
validEmail: function (email) {
var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
return re.test(email);
}
}
})
</script>

