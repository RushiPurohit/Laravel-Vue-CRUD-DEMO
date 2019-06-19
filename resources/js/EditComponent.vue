<template>
  <div>
    <div v-if="this.successMessage.length > 0">
        <div class="alert alert-success">{{this.successMessage}}</div>
    </div>
    <h1>Edit Post</h1>
    <form @submit.prevent="updatePost">
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
                      <img :src="images">
                      <input type="file" class="form-control" v-on:change="onImageChange">
                      <input type="hidden" class="form-control" v-model="photo">
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
          <button class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</template>

<script>
    export default {

      data() {
        
        return {
            title: '',
            first_name : '',
            last_name  : '',
            gender :'',
            images:'',
            body:'',
            photo:'',
            successMessage : []
          };
        
      },
      created() {
        let uri = `/api/post/edit/${this.$route.params.id}`;
        this.axios.get(uri).then((response) => {
            this.title = response.data.title;
            this.first_name = response.data.first_name;
            this.last_name = response.data.last_name;
            this.gender = response.data.gender;
            this.images = response.data.images;
            this.photo = response.data.images;
            this.body = response.data.body;
        });
      },
      methods: {
        onImageChange(e){

            console.log(e.target.files[0]);

            this.image = e.target.files[0];

        },
        updatePost(e) {
            e.preventDefault();
            
            let formData = new FormData();

            formData.append('image', this.image);
            formData.append('title', this.title);
            formData.append('first_name', this.first_name);
            formData.append('last_name', this.last_name);
            formData.append('gender', this.gender);
            formData.append('photo', this.photo);
            formData.append('body', this.body);
            let uri = `/api/post/update/${this.$route.params.id}`;
            axios.post(uri, formData)

            .then(response =>  {
                this.successMessage = response.data.message;
                this.images = response.data.data.images;

            })

            .catch(function (error) {


            });

        },
        // updatePost() {
        //   let uri = `http://localhost:8000/api/post/update/${this.$route.params.id}`;
        //   this.axios.post(uri, this.post).then((response) => {
        //     this.$router.push({name: 'posts'});
        //   });
        // }
      }
    }
</script>