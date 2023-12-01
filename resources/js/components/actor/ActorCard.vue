<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ name }}</h5>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ new Date(birthday).toLocaleDateString('fr-FR') + ' | ' + nationality }}</small>
                <div class="btn-group">
                    <a :href="'/actors/' + id " type="button" class="btn btn-sm btn-outline-secondary">Voir</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps([
        'id',
        'name',
        'birthday',
        'nationality',
    ])
</script>
