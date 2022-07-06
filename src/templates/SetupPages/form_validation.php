<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <!-- axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Vue2</title>
</head>
<body>
<style>
    .empty {
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
                        <input id="name" v-model="formData.name" type="text" name="name" class="form-control">

                    </div>

                    <!-- email -->
                    <div class="col-lg-6">
                        <label for="name">Email</label>
                        <input id="email" v-model="formData.email" type="email" name="email" class="form-control">

                    </div>

                    <!-- Favourite movie -->
                    <div class="col-lg-6">
                        <label for="movie">Favorite Movie</label>
                        <select id="movie" v-model="formData.movie" name="movie" class="form-control">
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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>
<!--------------------------------- end of  html ------------------------------------------------>
<script>

    const app = new Vue({
        el: '#app',
        data: {
            errors: [],
            formData: {},
            //FIELDS
            fields: {
                name: {rule: 'notBlank'},
                email: {rule: 'notBlank'},
                movie: {rule: 'notEqual', string: 'Star Wars'}
            }
        },
        methods: {

            checkForm: function (e) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = "<?= $csrf; ?>";
                this.errors = [];

                //loop
                Object.keys(this.fields).forEach(key => {

                    console.log(key);
                    console.log(this.fields[key]);
                    console.log(this.fields[key]['rule']);

                    let field = key;
                    let rule = this.fields[key]['rule'];
                    let string = this.fields[key]['string'];

                    if (rule === 'notBlank') {
                        if (!this.formData[field]) {
                            this.errors.push(field+" required.");
                            document.getElementById(field).classList.add('empty');
                        } else {
                            document.getElementById(field).classList.remove('empty');
                        }
                    } else if (rule === 'notEqual') {
                        if (!this.formData[field]) {
                            this.errors.push("Select "+field);
                            document.getElementById(field).classList.add('empty');
                        } else if (this.formData[field] === string) {
                            this.errors.push(string+" is not allowed");
                            document.getElementById(field).classList.add('empty');
                        } else {
                            document.getElementById(field).classList.remove('empty');
                        }
                    }

                });

                //array
                if (!this.errors.length) {
                    console.log('formdata - submit form');
                    console.log(this.formData);

                    var objData = JSON.stringify(this.formData);

                    console.log('objData');
                    console.log(objData);
                    let URL = "<?= $webroot; ?>en_US/SetupPages/submitForm";
                    axios.post(URL, objData).then(function (response) {
                        console.log("response");
                        console.log(response);
                        if (response.data.STATUS == 200) {
                            alert('SUCCESS '+response.data.MSG);
                        }
                    });
                }
                e.preventDefault();
            }
        }
    })
</script>
