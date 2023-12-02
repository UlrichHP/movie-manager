<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ genre.name }}</h5>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a :href="'/genres/' + genre.id " type="button" class="btn btn-sm btn-outline-secondary">Voir</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { GenreType } from "../../types/GenreType";

    defineProps<{
        genre: GenreType
    }>()
</script>
