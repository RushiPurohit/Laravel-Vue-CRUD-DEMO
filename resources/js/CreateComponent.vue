<template>
  <div>
    <div v-if="this.successMessage.length > 0">
        <div class="alert alert-success">{{this.successMessage}}</div>
    </div>
    <h1>Create A Post</h1>
    <form @submit="formSubmit" enctype="multipart/form-data">
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label>Post Title:</label>
                  <input type="text" class="form-control" v-model="title">
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label>First Name:</label>
                  <input type="text" class="form-control" v-model="first_name">
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label>Last Name:</label>
                  <input type="text" class="form-control" v-model="last_name">
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label>Gender:</label>
                  <input type="radio" value="1" v-model="gender"> Male
                  <input type="radio" value="0" v-model="gender"> Female
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label>Image:</label>
                  <input type="file" class="form-control" v-on:change="onImageChange">
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Body:</label>
            <textarea class="form-control" v-model="body" rows="5"></textarea>
          </div>
        </div>
      </div><br />
      <div class="form-group">
        <button class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
    export default {
      mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
              title: '',
              first_name : '',
              last_name  : '',
              gender :'',
              image:'',
              body:'',
              successMessage : []
            };
        },
      methods: {
        onImageChange(e){

            console.log(e.target.files[0]);

            this.image = e.target.files[0];

        },

        formSubmit(e) {
          
            e.preventDefault();            
            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('title', this.title);
            formData.append('first_name', this.first_name);
            formData.append('last_name', this.last_name);
            formData.append('gender', this.gender);
            formData.append('body', this.body);
            axios.post('/api/post/create', formData)
            .then(response =>  {
                this.successMessage = response.data.message
            })
            .catch(function (error) {
            });
        }      
    }
  }
</script> 