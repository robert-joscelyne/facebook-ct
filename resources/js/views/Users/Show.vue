<template>
    <div class="flex flex-col items-center">
        <div class="relative mb-8">
            <div class="w-100 h-64 overflow-hidden z-10">
                <img src="https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_960_720.jpg"
                     alt="user background image" class="object-cover w-full">
            </div>
            <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
                <div class="w-32">
                    <img src="https://images.generated.photos/uBNQ_00RqOyobQcoDurZG204PiSYLUKg4IhOmiJUgk8/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yz/XzAwNzMwMTMuanBn.jpg"
                    alt="User Profile Picture" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                </div>
                <p class="text-2xl text-gray-100 ml-4">{{ user.data.attributes.name }}</p>
            </div>
        </div>
        <div v-if="postLoading"><p>Loading posts</p></div>
        <Post v-else v-for="post in posts.data" :key="post.data.id" :post="post"/>
        <p v-if=" ! postLoading && posts.data.length < 1">No posts found</p>
    </div>
</template>

<script>
    import Post from '../../components/Post';

    export default {
        name: "Show",

        components: {
            Post
        },

        data: () => {
            return {
                user: null,
                posts: null,
                userLoading: true,
                postLoading: true,
            }
        },

        mounted() {
            axios.get('/api/users/' + this.$route.params.userId)
                .then(response => {
                    this.user = response.data;
                })
                .catch(error => {
                    console.log('Unable to fetch user details');
                })
                .finally(() => {
                    this.userLoading = false;
                });

            axios.get('/api/users/' + this.$route.params.userId + '/posts')
                .then(response => {
                    this.posts = response.data;
                })
                .catch(error => {
                    console.log('Unable to fetch posts');
                })
                .finally(() => {
                   this.postLoading = false;
                });
        },
    }
</script>

<style scoped>

</style>