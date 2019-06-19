<template>
  <div>
      <div v-if="this.successMessage.length > 0">
          <div class="alert alert-success">{{this.successMessage}}</div>
      </div>
      <h1>Posts</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <router-link :to="{ name: 'create' }" class="btn btn-primary">Create Post</router-link>
          </div>
        </div><br />

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Item Name</th>
                <th>Item Image</th>
                <th>Item Body</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="post in posts" :key="post.id">
                    <td>{{ post.id }}</td>
                    <td>{{ post.first_name }}{{ post.last_name }}</td>
                    <td>{{ post.gender == '1' ? 'Male' : 'Female' }}</td>
                    <td>{{ post.title }}</td>
                    <td><img :src="post.images" height="20%"></td>
                    <td>{{ post.body }}</td>
                    <td><router-link :to="{name: 'edit', params: { id: post.id }}" class="btn btn-primary" style="margin-right:10px">Edit</span></router-link><button class="btn btn-danger" @click.prevent="deletePost(post.id)">Delete</button></td>
                </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
  export default {
      data() {
        return {
          posts: [],
          successMessage: []
        }
      },
      created() {
      let uri = '/api/posts';
      this.axios.get(uri).then(response => {
        console.log(response);
        this.posts = response.data.data;
      });
    },
    methods: {
      deletePost(id)
      {
        let uri = `/api/post/delete/${id}`;
        this.axios.delete(uri).then(response => {
          //console.log(response);
          this.posts.splice(this.posts.indexOf(id), 1);
          this.successMessage = response.data.message;
        });
      }
    }
  }
</script>