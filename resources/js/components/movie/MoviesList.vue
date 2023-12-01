<template>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-3">
            <div class="col" v-for="movie in movies.data" :key="movie.id">
                <MovieCard v-bind="movie" />
            </div>
        </div>

        <Bootstrap5Pagination
            :data="movies"
            @pagination-change-page="getResults"
            align="center"
        />
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { Bootstrap5Pagination } from 'laravel-vue-pagination'
    import MovieCard from './MovieCard.vue';

    const movies = ref([])

    const getResults = async (page = 1) => {
        await axios
            .get('/api/movies', {
                params: {
                    page,
                }
            })
            .then((res) => movies.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
