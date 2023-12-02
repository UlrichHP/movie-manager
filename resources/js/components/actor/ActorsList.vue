<template>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-3">
            <div class="col" v-for="actor in actors.data" :key="actor.id">
                <MovieCard :actor="actor" />
            </div>
        </div>

        <Bootstrap5Pagination
            :data="actors"
            @pagination-change-page="getResults"
            align="center"
        />
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { Bootstrap5Pagination } from 'laravel-vue-pagination'
    import MovieCard from './ActorCard.vue';

    const actors = ref([])

    const getResults = async (page = 1) => {
        await axios
            .get('/api/actors', {
                params: {
                    page,
                }
            })
            .then((res) => actors.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
